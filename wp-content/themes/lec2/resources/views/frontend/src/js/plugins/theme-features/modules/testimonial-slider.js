function initTestimonialSlider() {
  $(document).ready(() => {
    const $testtimonialSlider = $('.testimonial-list');

    function addLeftRightClass($currentSlide) {
      const $prev1 = $currentSlide.prev('.testimonial-item');
      const $prev2 = $prev1.prev('.testimonial-item');
      const $prev3 = $prev2.prev('.testimonial-item');
      const $prev4 = $prev3.prev('.testimonial-item');
      const $next1 = $currentSlide.next('.testimonial-item');
      const $next2 = $next1.next('.testimonial-item');
      const $next3 = $next2.next('.testimonial-item');
      const $next4 = $next3.next('.testimonial-item');

      if ($prev1) {
        $prev1.addClass('slick-slide-aside-left slick-slide-aside-1');
      }
      if ($prev2) {
        $prev2.addClass('slick-slide-aside-left slick-slide-aside-2');
      }
      if ($prev3) {
        $prev3.addClass('slick-slide-aside-left slick-slide-aside-3');
      }
      if ($prev4) {
        $prev4.addClass('slick-slide-aside-left slick-slide-aside-4');
      }

      if ($next1) {
        $next1.addClass('slick-slide-aside-right slick-slide-aside-1');
      }
      if ($next2) {
        $next2.addClass('slick-slide-aside-right slick-slide-aside-2');
      }
      if ($next3) {
        $next3.addClass('slick-slide-aside-right slick-slide-aside-3');
      }
      if ($next4) {
        $next4.addClass('slick-slide-aside-right slick-slide-aside-4');
      }
    }

    if ($testtimonialSlider.length) {
      $testtimonialSlider
        .on('init', (event, slick, direction) => {
          const $currentSlide = $(slick.$slides[slick.currentSlide]);
          addLeftRightClass($currentSlide);
        })
        .slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          dots: false,
          centerMode: true,
          variableWidth: true,
          infinite: true,
          focusOnSelect: true,
          cssEase: 'linear',
          touchMove: true,
          prevArrow: '<button type="button" class="slick-prev">&nbsp;</button>',
        });

      $testtimonialSlider.on('beforeChange', (event, slick, currentSlide) => {
        const $sliderItems = slick.$slider.find('.testimonial-item');
        $sliderItems.removeClass('slick-slide-aside-left slick-slide-aside-right slick-slide-aside-1 slick-slide-aside-2 slick-slide-aside-3 slick-slide-aside-4');
      });

      $testtimonialSlider.on('afterChange', (event, slick, currentSlide) => {
        const $currentSlide = $(slick.$slides[currentSlide]);

        addLeftRightClass($currentSlide);
      });
    }
  });
}

export default initTestimonialSlider;
