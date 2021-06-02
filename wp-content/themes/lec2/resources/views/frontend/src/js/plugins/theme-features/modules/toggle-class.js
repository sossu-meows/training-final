export default function initToggleClass() {
  // DECLARES
  function initToggleSelfClass() {
    const dataTarget = 'data-toggle-class-target';
    const dataValue = 'data-toggle-class';
    const selector = `[${dataValue}]`;

    $(document).on('click', selector, function (e) {
      const targetSelector = $(this).attr(dataTarget);
      const $target = targetSelector ? $(targetSelector) : $(this);
      $target.toggleClass($(this).attr(dataValue));
    });
  }

  function initToggleParentClass() {
    // Toggle parent class
    const dataTarget = 'data-parent-target';
    const dataValue = 'data-toggle-parent-class';
    const selector = `[${dataValue}]`;

    $(document).on('click', selector, function (e) {
      const parentFilter = $(this).attr(dataTarget);
      const $target = parentFilter ? $(this).closest(parentFilter) : $(this).parent();
      $target.toggleClass($(this).attr(dataValue));
    });
  }

  // MAIN INITs
  initToggleSelfClass();
  initToggleParentClass();
}
