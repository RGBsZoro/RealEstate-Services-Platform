<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js";
    import {
        getMessaging,
        getToken,
        onMessage
    } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyD7iQpIq5pjC3OFLcHCheXvUCd3_Tr-dcc",
        authDomain: "realestate-services-plat-30007.firebaseapp.com",
        projectId: "realestate-services-plat-30007",
        storageBucket: "realestate-services-plat-30007.firebasestorage.app",
        messagingSenderId: "311963055314",
        appId: "1:311963055314:web:ea916081d697432962a90b",
        measurementId: "G-571R98TR0G"
    };

    // ... الاستدعاءات والإعدادات بقيت كما هي ...
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// 1. تسجيل الـ Service Worker أولاً
navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then(registration => {
        console.log('SW registered successfully');

        // 2. طلب الصلاحية بعد نجاح التسجيل
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                console.log('Permission granted');
                
                // 3. جلب التوكن مع تمرير الـ registration ومفتاح Vapid
                getToken(messaging, {
                    vapidKey: "BMcORtsdig4aiPqnkpjC6Y-DzU2Eowr7A4L9kWousf1FC2g0MqqwjoEmkCYjGc0fS2Rrn4WnGkjGCOmlucJT4Ck",
                    serviceWorkerRegistration: registration // 🔥 سطر بالغ الأهمية
                }).then(token => {
                    console.log('FCM Token:', token);
                    
                    // إرسال التوكن للباك إند
                    fetch('/fcm/register-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ token })
                    }).then(res => res.json())
                      .then(data => console.log('Token Saved:', data));
                });
            } else {
                console.log('Permission not granted');
            }
        });
    })
    .catch(err => console.error('SW Registration failed:', err));

// ... باقي الكود (onMessage) يبقى كما هو ...

    // Foreground handler
    // onMessage(messaging, payload => {
    //     console.log('FCM Foreground:', payload);

    //     // ✅ عرض notification في foreground
    //     if (Notification.permission === 'granted') {
    //         new Notification(payload.notification.title, {
    //             body: payload.notification.body,
    //             icon: '/logo.png'
    //         });
    //     }

    //     // (اختياري) event
    //     window.dispatchEvent(new CustomEvent('fcm-message', {
    //         detail: payload
    //     }));
    // });
    
    // onMessage(messaging, payload => {
    //     console.log('FCM Foreground:', payload);

    //     // استخدام SweetAlert لإظهار تنبيه داخلي شيك
    //     Swal.fire({
    //         title: payload.notification.title,
    //         text: payload.notification.body,
    //         icon: 'info',
    //         toast: true,
    //         position: 'top-end',
    //         showConfirmButton: false,
    //         timer: 5000,
    //         timerProgressBar: true,
    //         didOpen: (toast) => {
    //             toast.addEventListener('mouseenter', Swal.stopTimer)
    //             toast.addEventListener('mouseleave', Swal.resumeTimer)
    //             // إضافة إمكانية الضغط على التنبيه للذهاب للرابط
    //             toast.addEventListener('click', () => {
    //                 if(payload.data.url) window.location.href = payload.data.url;
    //             })
    //         }
    //     });
    // });

    onMessage(messaging, (payload) => {
        console.log('FCM Payload Received:', payload);

        // 1. استخراج البيانات (تحسباً لوصولها في data أو notification)
        const title = payload.notification?.title || payload.data?.title || "<?php echo e(__('header.new_notification')); ?>";
        const body = payload.notification?.body || payload.data?.body || "";
        const targetUrl = payload.data?.url || "#";

        // 2. إظهار تنبيه المتصفح الأصلي (Native Notification)
        if (Notification.permission === 'granted') {
            new Notification(title, {
                body: body,
                icon: '/logo.png' // تأكد من مسار اللوجو
            });
        }

        // 3. إظهار تنبيه SweetAlert (إذا كانت المكتبة محملة)
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: body,
                icon: 'info',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                showCloseButton: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                    toast.style.cursor = 'pointer';
                    toast.addEventListener('click', () => {
                        window.location.href = targetUrl;
                    });
                }
            });
        } else {
            console.warn('SweetAlert (Swal) is not defined. Please include the library.');
        }

        // 4. تحديث عداد الإشعارات في الهيدر تلقائياً (اختياري لكنه احترافي)
        updateNotificationDot();
    });

    // دالة بسيطة لتفعيل الجرس أو النقطة الحمراء بدون تحديث الصفحة
    function updateNotificationDot() {
        const bellIcon = document.querySelector('.bx-bell');
        const badge = document.querySelector('.badge-notifications');
        
        if (bellIcon) bellIcon.classList.add('bell-shake');
        if (!badge) {
            // كود لإضافة النقطة الحمراء إذا لم تكن موجودة
            const navLink = document.querySelector('.dropdown-notifications .nav-link');
            const newBadge = document.createElement('span');
            newBadge.className = 'badge bg-danger badge-dot badge-notifications position-absolute top-0 start-100 translate-middle mt-2 ms-n2 border border-2 border-white';
            navLink.appendChild(newBadge);
        }
    }

    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(registration => {
            console.log('SW registered');
        })
        .catch(err => console.error('SW failed', err));
</script>
<?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/_partials/firebase.blade.php ENDPATH**/ ?>