import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';

class PartnersController extends AbstractController {
  main() {
    // this.$scope.partnerList = {
    //   items: [],
    //   pageNumber: 1,
    // };
    // this.initLoadMore();
  }

  initLoadMore() {
    const $partnerBlock = $('.partner-card-block');
    const $LoadMoreBtn = $partnerBlock.find('#loadMore');

    const $partnerList = $('#partner-listing');
    $partnerList.loading(true);

    $LoadMoreBtn.on('click', async () => {
      try {
        $LoadMoreBtn.loading(true);
        $partnerList.addClass('loading');
        const pageNumber = this.$scope.partnerList.pageNumber;

        const data = {
          postsPerPage: global.viewport.isMobile ? 6 : 12,
          pageNumber,
        };

        const resp = await AjaxService.getInstance().getMorePartner(data);
        if (resp) {
          this.$scope.partnerList = {
            items: [...this.$scope.partnerList.items, ...resp.data],
            pageNumber,
          };
          this.$scope.partnerList.pageNumber++;

          if (!resp.show_load_more) {
            $LoadMoreBtn.hide();
          } else {
            $LoadMoreBtn.show();
          }
        }
      } catch (error) {
        console.error(error);
      }
      $LoadMoreBtn.loading(false);
      $partnerList.removeClass('loading');
      $partnerList.loading(false);
    });
    $LoadMoreBtn.trigger('click');
    $LoadMoreBtn.hide();
  }
}

export default PartnersController;
