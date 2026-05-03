<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Modern Real-time Chat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;600&display=swap" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg-dark: #0f172a;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
            background: radial-gradient(circle at top left, #1e1b4b, #0f172a);
            color: #f8fafc;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-container {
            width: 100%;
            max-width: 500px;
            height: 80vh;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .chat-header {
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--glass-border);
            text-align: center;
        }

        .chat-header h1 {
            font-size: 1.2rem;
            margin: 0;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            margin-left: 8px;
            box-shadow: 0 0 10px #22c55e;
        }

        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            list-style: none;
            display: flex;
            flex-direction: column-reverse;
            gap: 12px;
        }

        .message-item {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 0.95rem;
            line-height: 1.5;
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-mine {
            align-self: flex-start;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-item.pending {
            opacity: 0.7;
            position: relative;
        }

        .message-item.pending::after {
            content: '...⏳';
            font-size: 0.7rem;
            margin-right: 5px;
        }
        .message-others {
            align-self: flex-end;
            background: var(--glass-border);
            color: #e2e8f0;
            border-bottom-left-radius: 4px;
        }

        .chat-footer {
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
        }

        #form {
            display: flex;
            gap: 10px;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px;
            border-radius: 16px;
            border: 1px solid var(--glass-border);
        }

        #message {
            flex: 1;
            background: transparent;
            border: none;
            color: white;
            padding: 10px;
            outline: none;
            font-size: 0.9rem;
        }

        button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        button:hover {
            background: var(--secondary);
            transform: scale(1.05);
        }

        #messages::-webkit-scrollbar { width: 4px; }
        #messages::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 10px; }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <h1><span class="status-dot"></span> Chats </h1>
    </div>

    <ul id="messages">
    </ul>

    <div class="chat-footer">
        <form id="form">
            <input type="text" id="message" placeholder="اكتب رسالتك هنا..." autocomplete="off" required>
            <button type="submit">إرسال</button>
        </form>
    </div>
</div>

</body>
</html><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/chat.blade.php ENDPATH**/ ?>