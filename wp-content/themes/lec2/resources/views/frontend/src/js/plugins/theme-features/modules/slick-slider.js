function initSlickSlider() {
  $(document).ready(() => {
    const $eleSlick = $('[data-slick]');
    $eleSlick.slick();
  });
}

export default initSlickSlider;
