import './bootstrap.js';

import './styles/app.min.css';

document.addEventListener('turbo:load', function () {
  const flashMessages = document.querySelectorAll('.flash-message');
  flashMessages.forEach((message) => {
    setTimeout(() => {
      message.style.opacity = '0';
      setTimeout(() => message.remove(), 1000);
    }, 3000);
  });
});
