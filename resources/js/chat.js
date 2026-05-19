document.addEventListener('DOMContentLoaded', () => {
  initEcho();
  initForm();
});

function initEcho() {
  const ids = [window.chatConfig.myId, window.chatConfig.receiverId].sort((a, b) => a - b);
  const channelName = `chat.${ids[0]}.${ids[1]}`;

  window.Echo.private(channelName).listen('.message.sent', data => {
    if (data.senderId != window.chatConfig.myId) {
      appendMessage(data.message, 'others');
    }
  });
}

function initForm() {
  const form = document.getElementById('form');
  const input = document.getElementById('message');

  if (!form) return;

  form.addEventListener('submit', async e => {
    e.preventDefault();

    const message = input.value.trim();
    if (!message) return;

    const receiverId = window.chatConfig.receiverId; // جلب المعرف من الكونفيج
    input.value = '';

    appendMessage(message, 'mine');

    try {
      await fetch('/send-message', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'X-Socket-ID': window.Echo.socketId()
        },
        body: JSON.stringify({
          message: message,
          receiver_id: receiverId // إرسال المعرف للسيرفر
        })
      });
    } catch (error) {
      console.error('Connection Error');
    }
  });
}

function appendMessage(message, type = 'others') {
  const ul = document.getElementById('messages');
  if (!ul) return;

  const wrapper = document.createElement('div');
  wrapper.classList.add('message-wrapper');
  wrapper.classList.add(type === 'mine' ? 'mine-wrapper' : 'others-wrapper');

  const now = new Date();
  const timeStr = now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0');

  wrapper.innerHTML = `
        <li class="message-item ${type === 'mine' ? 'message-mine' : 'message-others'}">
            ${message}
        </li>
        <span class="message-time">${timeStr}</span>
    `;

  ul.prepend(wrapper);
}
