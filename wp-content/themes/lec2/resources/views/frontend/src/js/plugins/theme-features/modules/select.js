import { makeArray } from './../../../common/helpers/functions';

const IS_SELECTED_CLASS = 'is-selected';

function isEmptySelect($select) {
  const values = makeArray($select.val());
  const selecteds = values.filter(e => e !== '');
  return selecteds.length === 0;
}

/**
 * check empty state select event
 * @param {DOMEvent} e  select event
 */
function checkEmptyState(e) {
  const $target = $(e.target);
  const $offParent = $target.closest('.bootstrap-select');

  // style
  if (!isEmptySelect($target)) {
    $offParent.addClass(IS_SELECTED_CLASS);
  } else {
    $offParent.removeClass(IS_SELECTED_CLASS);
  }
}

async function initSelectBoxPicker() {
  const $select = $('.selectpicker');

  await $select.selectpicker({
    noneSelectedText: '',
    showTick: false,
  });

  // Listen to form reset
  $('form').on('reset', (event) => {
    const $innerSelect = $(event.currentTarget).find($select).val('');
    $select.selectpicker('refresh');

    setTimeout(() => {
      checkEmptyState({
        target: $innerSelect[0],
      });
    });
  });

  $select.on('change', (event) => {
    checkEmptyState(event);
  });

  $select.on('loaded.bs.select', (e) => {
    const $offParent = $(e.target).parent('.-select');
    if (e.target.value) {
      $offParent.addClass(IS_SELECTED_CLASS);
    }

    const $selectLabel = $offParent.prev('.select-label');
    $selectLabel.prependTo($offParent);

    checkEmptyState(e);
  });

  $select.on('changed.bs.select', (e, clickedIndex, isSelected) => {
    const $target = $(e.target);
    checkEmptyState(e);
    if (isSelected !== null && e.target.type === 'select-multiple') {
      $target.selectpicker('toggle');
    }
  });

  $select.on('rendered.bs.select', (e) => {
    const $offParent = $(e.target.offsetParent);
    // Fix blank option ,
    if (e.target.type === 'select-multiple') {
      const $target = $(e.target);
      const $buttonInner = $offParent.find('.filter-option-inner-inner');
      const values = $target.val() || [];
      const $selectedTexts = values.filter(val => val !== '').map(val => $target.find(`option[value="${val}"]`).text());
      $buttonInner.text($selectedTexts);
    }
  });

  $select.on('refreshed.bs.select', (e) => {
    checkEmptyState(e);
  });
}

export default initSelectBoxPicker;
