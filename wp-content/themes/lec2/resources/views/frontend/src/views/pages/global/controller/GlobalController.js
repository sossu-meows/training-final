import AbstractController from '@/@core/web/controllers/abstract';

class GlobalController extends AbstractController {
  main() {
    this.initCustomModal();
    this.loadAllEliComponents();
    if (global.nanobar) {
      global.nanobar.go(100);
    }
    this.handleSendOfferSubmit();
    this.handleSendOfferResponse();
  }

  loadAllEliComponents() {
    const requireComponent = require.context('@/views/components/', true, /([^/]+)\/([^/]+)\.js$/);
    requireComponent.keys().forEach((fileName) => {
      const [, componentFolderName, componentScript] = /([^/]+)\/([^/]+)\.js$/.exec(fileName);
      // If folder name equal to js name, we load this file
      if (componentFolderName === componentScript) {
        const Component = requireComponent(fileName).default;
        if (Component.initEliComponent) {
          Component.initEliComponent();
        }
      }
    });
  }

  handleSendOfferSubmit() {
    $(document).on('submit', '.es_subscription_form', function (e) {
      $(this).addClass('is-submiting');
    });
  }

  handleSendOfferResponse() {
    $(window).on('es.send_response', (event, $form, response) => {
      $form.removeClass('is-submiting');
      if (response.status === 'SUCCESS') {
        const mesage = global.eli.form_offer.newsletter_success_message;

        $form.next('.es_subscription_message').hide();
        global.swal.fire({
          icon: '',
          title: 'Success',
          html: mesage,
          showConfirmButton: true,
          padding: '4.2rem 3.9rem',
          customClass: {
            container: 'swal2-container--newsletter',
          },
          // timer: 5000,
        });
        $form[0].reset();
        $form.find('#spinner-image').hide();
      } else {
        $form.next('.es_subscription_message').show();
      }
    });
  }

  initCustomModal() {
    const $clickedEl = $('[data-custom-modal]');
    const overlayBg = '<div class="bg-modal"></div>';

    const setTargetPosition = ($el, $clickedEle, position) => {
      if (position === 'right') {
        $el.css({
          right: $(document).width() - $clickedEle.offset().left - $clickedEle.width(),
        });
      } else {
        $el.css({
          left: $clickedEle.offset().left,
        });
      }
    };

    const showTargetBox = ($clickedTarget, $clickedEl) => {
      $clickedTarget.addClass('show');
      $clickedEl.addClass('active');
      $('body').append(overlayBg).addClass('show-modal');
    };

    const hideTargetBox = ($clickedTarget, $clickedEl) => {
      $clickedTarget.removeClass('show');
      $clickedEl.removeClass('active');
      $('.bg-modal').remove();
      $('body').removeClass('show-modal');
    };
    if (global.viewport.isDesktop) {
      $clickedEl.on('click', function (e) {
        e.preventDefault();
        const $clickedTarget = $($(this).data('custom-modal'));
        const position = $(this).data('show');

        setTargetPosition($clickedTarget, $clickedEl, position);
        if ($clickedTarget.hasClass('show')) {
          hideTargetBox($clickedTarget, $clickedEl);
        } else {
          showTargetBox($clickedTarget, $clickedEl);
        }
      });

      const $closeTrigger = $('[data-close-trigger]');
      $closeTrigger.on('click', function () {
        const $triggerClass = $($(this).data('close-trigger'));
        $triggerClass.trigger('click');
      });
    }

    const $filterModules = $('#filterModules');
    const $scheduleForm = $('#scheduleForm');
    const $clickMenuItem = $('.menu-item--arrow');

    // move #filterModules to sub menu of .menu-item--training-modules
    $('#filterModules').appendTo('.menu-item--training-modules');

    $clickMenuItem.on('click', '> a', function (e) {
      const $parent = $(this).parent('li');
      if ($parent.hasClass('menu-item--training-modules')) {
        e.preventDefault();
        setTargetPosition($filterModules, $parent, 'left');
        if ($filterModules.is(':hidden')) {
          showTargetBox($filterModules, $parent);
        } else {
          hideTargetBox($filterModules, $parent);
        }
      }
      if ($parent.hasClass('menu-item--schedule') && global.viewport.isDesktop) {
        e.preventDefault();
        setTargetPosition($scheduleForm, $parent, 'left');
        if ($scheduleForm.is(':hidden')) {
          showTargetBox($scheduleForm, $parent);
        } else {
          hideTargetBox($scheduleForm, $parent);
        }
      }
    });

    $(document).on('click', '.bg-modal', () => {
      $('.filter-header').removeClass('show');
      $('.menu-item--arrow, [data-custom-modal]').removeClass('active');
      $('.bg-modal').remove();
      $('body').removeClass('show-modal');
    });
  }
}

export default GlobalController;
