import Blazy from 'blazy';

export default function initImageLazyLoad() {
  const blazyManager = new Blazy({
    offset: 400,
    success: (element) => {
      $(element).trigger('lazy-loaded');
    },
  });

  $(document).on('reInit init afterChange', '.slick-slider', (event) => {
    const $images = $(event.currentTarget).find('.b-lazy');
    blazyManager.revalidate($images.toArray(), true);
  });
}

