import './easy-loading.scss';

function initEasyLoading() {
  // CONSTs
  const settings = {
    componentClass: 'easy-loading',
    loadingClass: 'is-loading',
  };

  // DECLARE
  const dataKeys = {
    isAddedSpinner: 'isAddedSpinner',
  };

  // FUNCTIONS
  const appendSpinner = ($element) => {
    if (!$element.data(dataKeys.isAddedSpinner)) {
      $element.addClass(settings.componentClass);
      $element.data(dataKeys.isAddedSpinner, true);
      $element.prepend(`
        <span class="loading-content">
          <span class="loading-overlay">
          </span>
          <span class="loading-icon">
          </span>
        </span>
      `);
    }
  };

  $.fn.loading = function (isLoading, options) {
    const $element = $(this);

    appendSpinner($element);

    if (isLoading) {
      $element.addClass(settings.loadingClass);
    } else {
      $element.removeClass(settings.loadingClass);
    }
  };
}

initEasyLoading();
