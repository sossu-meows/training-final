import './back-to-top.scss';

const elementId = 'back-to-top';

function backToTopHTML() {
  return `
    <a id="${elementId}" href="javascript:;" title="Back to top" class="back-to-top">
    </a>
  `;
}

export default function installBackToTop() {
  if ($(`#${elementId}`).length === 0) {
    $(document.body).append(backToTopHTML());
  }
  const $footerEl = $('.site-footer');
  const $btnBackToTop = $(`#${elementId}`);
  if ($btnBackToTop.length) {
    const scrollTrigger = 100;
    const triggerShowBackToTop = function () {
      const scrollTop = $(window).scrollTop();
      if (scrollTop > scrollTrigger) {
        $btnBackToTop.addClass('show');
      } else {
        $btnBackToTop.removeClass('show');
      }
    };

    // Hide/show
    triggerShowBackToTop();
    $(window).on('scroll', () => {
      triggerShowBackToTop();
    });

    $btnBackToTop.on('click', (e) => {
      e.preventDefault();
      $('html,body').animate(
        {
          scrollTop: 0,
        },
        700,
      );
    });

    // back top top postion
    const getFooterHeight = () => {
      return $footerEl.outerHeight() + 20;
    };

    $btnBackToTop.css('bottom', getFooterHeight());
    $(window).on('resize', () => {
      $btnBackToTop.css('bottom', getFooterHeight());
    });
  }
}
