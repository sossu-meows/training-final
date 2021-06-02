import { scrollToElement } from '@/js/common/helpers/functions';

function getMarginOffset(target) {
  const offsetMobile = $(target).data('scroll-offset-mobile') || 0;
  const offsetAll = $(target).data('scroll-offset') || 0;
  let targetMargin;

  // get offset by device
  if (offsetMobile && global.viewport.isMobile) {
    targetMargin = offsetMobile;
  } else {
    targetMargin = offsetAll;
  }
  // if using vw unit
  if (/(\d+)vw/.test(targetMargin)) {
    const [, number] = /(\d+)vw/.exec(targetMargin);
    targetMargin = Number(number) * ($(window).width() / 100);
  }
  return targetMargin;
}

function handleScrollToTargetOnLinkClick(event) {
  event.preventDefault();
  event.stopPropagation();
  const $currentTarget = $(event.currentTarget);
  const target = $currentTarget.attr('href');
  const offset = $currentTarget.data('offset') || 0;
  const disabled = $currentTarget.data('disabled') || false;
  if (target && !disabled) {
    const finalOffset = offset + global.viewport.headerHeight;
    const targetMargin = getMarginOffset(target);
    scrollToElement(target, {
      offset: finalOffset + targetMargin,
    });
  }
}

export function initScrollToTarget(selector) {
  // scroll to
  $(document).on('click', selector, (event) => {
    handleScrollToTargetOnLinkClick(event);
  });
}

export default function initScrollTo() {
  // scroll to
  $(document).on('click', '.scroll-to', (event) => {
    handleScrollToTargetOnLinkClick(event);
  });
}
