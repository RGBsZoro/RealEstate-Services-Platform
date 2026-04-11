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

    Notification.requestPermission().then(permission => {
        if (permission === 'granted') {
            console.log('indise')
            getToken(messaging, {
                vapidKey: "BC1bq4Bc5gE4H5-fNA28HFgLwqT5xIYCuS8eZk_BKJsU_NGTOFxfYLxYyjO1WSfOfsCPpR4CFjfLVoA4g-CI0j8"
            }).then(token => {
                console.log('FCM Token:', token);

                fetch('/fcm/register-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json', // 🔥 IMPORTANT
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            token
                        })
                    })
                    .then(async res => {
                        const text = await res.text(); // see raw response
                        console.log('RAW RESPONSE:', text);
                        return JSON.parse(text);
                    })
                    .then(data => console.log('OK:', data))
                    .catch(err => console.error('ERROR:', err));

            });
        } else {
            console.log('Permission not granted for notifications');
        }
    });

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
    onMessage(messaging, payload => {
        console.log('FCM Foreground:', payload);

        // استخدام SweetAlert لإظهار تنبيه داخلي شيك
        Swal.fire({
            title: payload.notification.title,
            text: payload.notification.body,
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                // إضافة إمكانية الضغط على التنبيه للذهاب للرابط
                toast.addEventListener('click', () => {
                    if(payload.data.url) window.location.href = payload.data.url;
                })
            }
        });
    });

    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(registration => {
            console.log('SW registered');
        })
        .catch(err => console.error('SW failed', err));
</script>
