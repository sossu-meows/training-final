/* eslint-disable max-len */
import './style.scss';

const defaultOptions = {
  message: 'Nous utilisons des cookies pour nous permettre de mieux comprendre comment le site est utilisé. En continuant à utiliser ce site, vous acceptez cette politique.',
  buttonText: 'OK',
  link: '',
};

export default function initCookieMessage(options = {}) {
  options = {
    message: options.message || defaultOptions.message,
    buttonText: options.buttonText || defaultOptions.buttonText,
    link: options.link || defaultOptions.link,
  };
  const key = 'accepted_cookie';
  const isAccepted = localStorage.getItem(key);
  const template = `
    <div class="cookie-message">
      <div class="cookie-message__inner">
        <span>
          ${options.message}&nbsp;
        </span>
          ${options.link}
        <button class="btn btn-accept">
          ${options.buttonText}
        </button>
      </div>
    </div>
  `;

  if (!isAccepted) {
    if (!$('.cookie-message').length) {
      $('body').append(template);
    }

    $(document).on('click', '.cookie-message .btn-accept', () => {
      localStorage.setItem(key, 1);
      $('.cookie-message').remove();
    });
  }
}
