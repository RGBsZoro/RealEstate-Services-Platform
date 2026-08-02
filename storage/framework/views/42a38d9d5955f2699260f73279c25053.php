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

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(registration => {
            console.log('SW registered successfully');

            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Permission granted');
                    
                    getToken(messaging, {
                        vapidKey: "BKN1uxnlEaP39y3a1OWzbRw6DvoSTW7wSYKNe34yV7_aWTeclXejl3QYqHYqApj0rqZozmOSkaHoq8Ty6sNRdtQ",
                        serviceWorkerRegistration: registration
                    }).then(token => {
                        console.log('FCM Token:', token);
                        
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

    // Foreground handler
    onMessage(messaging, (payload) => {
        console.log('FCM Payload Received:', payload);

        const title = payload.notification?.title || payload.data?.title || "<?php echo e(__('header.new_notification')); ?>";
        const body = payload.notification?.body || payload.data?.body || "";
        const targetUrl = payload.data?.url || "#";


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
            if (Notification.permission === 'granted') {
                new Notification(title, { body: body, icon: '/logo.png' });
            }
        }

        updateNotificationDot();
    });

    function updateNotificationDot() {
        const bellIcon = document.querySelector('.bx-bell');
        const badge = document.querySelector('.badge-notifications');
        
        if (bellIcon) bellIcon.classList.add('bell-shake');
        if (!badge) {
            const navLink = document.querySelector('.dropdown-notifications .nav-link');
            if (navLink) {
                const newBadge = document.createElement('span');
                newBadge.className = 'badge bg-danger badge-dot badge-notifications position-absolute top-0 start-100 translate-middle mt-2 ms-n2 border border-2 border-white';
                navLink.appendChild(newBadge);
            }
        }
    }

</script><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/_partials/firebase.blade.php ENDPATH**/ ?>