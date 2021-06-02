import { eliComponent } from '@/@core/web/eli-component';
import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class NewsFeed
 */
@eliComponent({
  selector: '.js-news-feed-block',
})

class NewsFeed extends AbstractController {
  /**
   * Main init contact map
   */
  main() {
    this.slickOption = {
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      autoplay: false,
      infinite: false,
      centerPadding: '20px',
      responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      }],
    };

    this.$newsFeedBlock = $('.news-feed-block');
    this.$slickSlider = this.$newsFeedBlock.find('.news-feed-list');
    this.$LoadMoreBtn = this.$newsFeedBlock.find('.news-feed-btn .btn');

    this.$scope.postList = {
      items: [],
    };

    this.getMorePostFirst();
    // this.initLoadMorePost();
  }

  getMorePost = async (postsPerPage) => {
    const {
      $LoadMoreBtn, $slickSlider, $newsFeedBlock,
    } = this;

    const data = {
      postsPerPage,
    };
    $newsFeedBlock.removeClass('hide');
    $newsFeedBlock.addClass('is-loading-post');
    $newsFeedBlock.loading(true);
    $LoadMoreBtn.hide();
    try {
      const resp = await AjaxService.getInstance().getMorePost(data);
      if (resp) {
        this.$scope.postList = {
          items: [...resp.data],
        };
        $slickSlider.slick(this.slickOption);
      }
    } catch (error) {
      console.error(error);
    }
    $newsFeedBlock.removeClass('is-loading-post');
    $newsFeedBlock.loading(false);
    $LoadMoreBtn.show();
  }

  getMorePostFirst() {
    this.getMorePost(6);
  }

  // initLoadMorePost() {
  //   const { $LoadMoreBtn, $newsFeedBlock, $slickSlider } = this;
  //   $LoadMoreBtn.on('click', () => {
  //     $slickSlider.slick('unslick');
  //     this.getMorePost(-1);
  //     $LoadMoreBtn.hide();
  //   });
  // }
}

export default NewsFeed;
