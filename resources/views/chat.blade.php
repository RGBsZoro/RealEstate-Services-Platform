<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>المحادثة مع {{ $receiver->name }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <script>
        window.chatConfig = {
            myId: {{ auth('web')->id() }},
            receiverId: {{ $receiver->id }},
            receiverName: "{{ $receiver->name }}"
        };
    </script>
    @vite(['resources/js/app.js'])

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg-dark: #0f172a;
            --glass: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
            background: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            color: var(--text-main);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .chat-container {
            width: 95%;
            max-width: 550px;
            height: 90vh;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* الهيدر المحسن */
        .chat-header {
            padding: 16px 24px;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .user-details h2 {
            font-size: 1rem;
            margin: 0;
            color: var(--text-main);
        }

        .user-details span {
            font-size: 0.75rem;
            color: #22c55e;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* منطقة الرسائل */
        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            list-style: none;
            display: flex;
            flex-direction: column-reverse; /* لعرض الرسائل الجديدة في الأسفل */
            gap: 16px;
            scroll-behavior: smooth;
        }

        .message-wrapper {
            display: flex;
            flex-direction: column;
            max-width: 85%;
        }

        .message-item {
            padding: 12px 18px;
            font-size: 0.95rem;
            line-height: 1.6;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* رسائلي (يمين في RTL) */
        .mine-wrapper {
            align-self: flex-start; /* flex-start في RTL تعني اليمين */
        }
        .message-mine {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 18px 18px 4px 18px;
        }

        /* رسائل الطرف الآخر (يسار في RTL) */
        .others-wrapper {
            align-self: flex-end;
        }
        .message-others {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-main);
            border: 1px solid var(--glass-border);
            border-radius: 18px 18px 18px 4px;
        }

        .message-time {
            font-size: 0.65rem;
            margin-top: 5px;
            color: var(--text-dim);
            align-self: flex-end;
        }

        /* الفوتر ومنطقة الإدخال */
        .chat-footer {
            padding: 20px 24px;
            background: rgba(15, 23, 42, 0.4);
        }

        #form {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.05);
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        #form:focus-within {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
        }

        #message {
            flex: 1;
            background: transparent;
            border: none;
            color: white;
            padding: 10px;
            outline: none;
            font-size: 0.95rem;
        }

        .send-btn {
            background: var(--primary);
            color: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .send-btn:hover {
            transform: scale(1.1) rotate(-10deg);
            background: var(--secondary);
        }

        .send-btn i {
            font-size: 1.4rem;
        }

        /* تحسين التمرير */
        #messages::-webkit-scrollbar { width: 5px; }
        #messages::-webkit-scrollbar-thumb { 
            background: rgba(255,255,255,0.1); 
            border-radius: 10px; 
        }

        /* أنيميشن */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .message-wrapper { animation: slideIn 0.3s ease-out; }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <div class="user-info">
            <div class="avatar">
                @if($receiver->hasMedia('admin_avatars'))
                    <img src="{{ $receiver->getFirstMediaUrl('admin_avatars') }}" 
                        alt="{{ $receiver->name }}" 
                        style="width: 100%; height: 100%; border-radius: inherit; object-fit: cover;">
                @else
                    {{ substr($receiver->name, 0, 1) }}
                @endif
            </div>
            <div class="user-details">
                <h2>{{ $receiver->name }}</h2>
                <span><i class='bx bxs-circle'></i> متصل الآن</span>
            </div>
        </div>
        <div class="header-actions">
            <button style="background:none; border:none; color:var(--text-dim); cursor:pointer;">
                <i class='bx bx-dots-vertical-rounded fs-4'></i>
            </button>
        </div>
    </div>

    <ul id="messages">
        </ul>

    <div class="chat-footer">
        <form id="form">
            <input type="text" id="message" placeholder="اكتب رسالتك هنا..." autocomplete="off" required>
            
            <button type="submit" class="send-btn">
                <i class='bx bxs-send'></i>
            </button>
        </form>
    </div>
</div>

</body>
</html>