export function mobileMenuHanlder() {
  const $menuToggle = $('.site-header').find('.menu-toggle');
  const $target = $($menuToggle.data('href'));
  $menuToggle.on('click', () => {
    $menuToggle.toggleClass('active');
    $('body').toggleClass('show-nav-mobile');
    if ($target.is(':hidden')) {
      $target.slideDown('400');
    } else {
      $target.slideUp('400');
    }
  });
}

export function activeMenuHanlder() {
  function activeMenu($aTags) {
    const getFullUrl = (url) => {
      let a;
      if (!a) a = document.createElement('a');
      a.href = url;
      return a.href;
    };

    let currentUrl = getFullUrl(location.pathname);
    const regex = /.*\/$/gm;
    if (currentUrl.match(regex)) {
      currentUrl = currentUrl.substring(0, currentUrl.length - 1);
    }

    // select any url has word 'trainings'
    const regexTraining = /trainings/;
    let currentTrainingMenu;
    if (currentUrl.match(regexTraining)) {
      currentTrainingMenu = currentUrl;
    }

    // select any url has word 'partners'
    const regexPartners = /partners/;
    let currentPartnerMenu;
    if (currentUrl.match(regexPartners)) {
      currentPartnerMenu = currentUrl;
    }

    // select any url has word 'partners'
    const regexNews = /news/;
    let currentNewsMenu;
    if (currentUrl.match(regexNews)) {
      currentNewsMenu = currentUrl;
    }

    const checkAndActive = (a) => {
      const aUrl = getFullUrl(a.href);
      if ($(a).attr('href') && aUrl === currentUrl) {
        $(a).parent().addClass('current-menu-item');
      } else if ($(a).attr('href') && currentTrainingMenu) {
        $(a).parent('.trainingActive').addClass('current-menu-item');
      } else if ($(a).attr('href') && currentPartnerMenu) {
        $(a).parent('.partnerActive').addClass('current-menu-item');
      } else if ($(a).attr('href') && currentNewsMenu) {
        $(a).parent('.newsActive').addClass('current-menu-item');
      }
    };

    $aTags.each((idz, a) => checkAndActive(a));
  }

  // Main init
  $(document).ready(() => {
    if (!global.is_adapter) {
      const $aTags = $('header .nav-menu').find('li a');
      activeMenu($aTags);
    }

    const $fmenuTags = $('.footer-menu').find('li a');
    activeMenu($fmenuTags);
  });
}
