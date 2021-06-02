import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';

class NewsController extends AbstractController {
  main() {
    this.slickOption = {
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      autoplay: false,
      infinite: false,
      centerPadding: '20px',
      responsive: [
        {
          breakpoint: 1025,
          settings: {
            initialSlide: 2,
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            initialSlide: 1,
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    };


    this.$newsBlock = $('.news-card-block');
    this.$LoadMoreBtn = this.$newsBlock.find('#loadMore');

    this.$newsList = this.$newsBlock.find('#news-item-listing');
    this.$newsWrapper = this.$newsBlock.find('.news-item-wrapper');
    this.$newsLink = this.$newsBlock.find('.news-link');

    this.$scope.newsList = {
      items: [],
      pageNumber: 1,
    };

    this.getMorePostFirst();
    this.initLoadMorePost();
  }

  getMorePost = async (postsPerPage) => {
    const {
      $LoadMoreBtn, $newsList, $newsWrapper, $newsLink,
    } = this;

    const pageNumber = this.$scope.newsList.pageNumber;

    const data = {
      postsPerPage,
      pageNumber,
    };

    $LoadMoreBtn.hide();
    $newsWrapper.loading(true);

    try {
      const resp = await AjaxService.getInstance().getMorePost(data);
      if (resp) {
        this.$scope.newsList = {
          items: [...this.$scope.newsList.items, ...resp.data],
          pageNumber,
        };

        this.$scope.newsList.pageNumber++;

        if (global.viewport.isMobile || global.viewport.isTablet) {
          $newsList.slick(this.slickOption);
        }

        $LoadMoreBtn.hide();

        if (resp.show_load_more) {
          $LoadMoreBtn.show();
        } else {
          $LoadMoreBtn.hide();
        }
      }
    } catch (error) {
      console.error(error);
    }
    $newsList.addClass('all-loaded');
    $newsLink.addClass('all-loaded');
    $newsWrapper.loading(false);
  }

  getMorePostFirst() {
    this.getMorePost(12);
  }

  initLoadMorePost() {
    const { $LoadMoreBtn, $newsList } = this;
    $LoadMoreBtn.on('click', () => {
      if (global.viewport.isMobile || global.viewport.isTablet) {
        $newsList.slick('unslick');
      }

      this.getMorePost(4);
    });
  }
}

export default NewsController;
