document.addEventListener('DOMContentLoaded', () => {
  initEcho();
  initForm();
});

function initEcho() {
  if (!window.Echo) {
    console.error('Echo not ready');
    return;
  }

  window.Echo.private('chat').listen('.message.sent', data => {
    appendMessage(data.message);
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
        body: JSON.stringify({ message })
      });
    } catch (error) {
      console.error('error');
    }
  });
}

function appendMessage(message, type = 'others') {
  const ul = document.getElementById('messages');
  if (!ul) return;

  const li = document.createElement('li');
  li.classList.add('message-item');

  li.classList.add(type === 'mine' ? 'message-mine' : 'message-others');

  li.textContent = message;
  ul.prepend(li);
}
