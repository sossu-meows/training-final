import { eliComponent } from '@/@core/web/eli-component';
import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class FilterShorties
 */
@eliComponent({
  selector: '.js-filter-shorties-form',
})
class FilterShorties extends AbstractController {
  selfClass = '.filter-shorties-form';

  /**
   * Main init filter map
   */
  main() {
    this.$scope.courseList = {
      items: [],
    };

    this.$FilterBlock = $('.filter-shorties-form');
    this.$FilterForm = this.$FilterBlock.find('form');
    this.formData = { posts_per_page: 10 };

    this.loadTraningListShorties(10);
    this.initFilterForm();
    this.handlePagination();
  }

  /**
   * init filter form
   */
  initFilterForm() {
    const { $FilterForm } = this;

    $FilterForm.formValidator({
      schema: (yup) => {
        return {
          training_cat_id: yup.mixed(),
        };
      },
      onSuccess: async ({ data, form }) => {
        data.page = 1;
        this.loadTraningListShorties(data);
      },
    });
  }

  async loadTraningListShorties(formData) {
    const { $FilterForm, $FilterBlock } = this;
    const $courseList = $('#shortiesForm .course-item-listing');
    const $noResult = $('.no-result');


    $FilterBlock.loading(true);
    // $FilterForm.loading(true);
    // this.$FilterBlock.addClass('loading');

    this.formData = {
      ...this.formData,
      ...formData,
    };

    try {
      const resp = await AjaxService.getInstance().sendShortiesCourse(this.formData, {
        noMessage: true,
      });

      if (resp) {
        this.$scope.courseList = {
          items: [...resp.items.data],
        };

        const $pagination = $('#pagination-filter-shorties');
        $pagination.html('');
        if (resp.items.total_pages > 1) {
          this.current_page = resp.items.current_page;

          // first page
          if (Number(resp.items.current_page) === 1) {
            $pagination.html(`<div class="page-num page-num--first" data-page="${resp.items.next_page}">More <em class="icon-chevron-right-solid"></em></div>`);
          } else {
            let html = `<div class="page-num page-num--prev" data-page="${resp.items.current_page - 1}"><em class="icon-arrow-left"></em></div>`;
            html = html.concat(`<div class="page-num page-num--current" data-page="${resp.items.next_page}">Next</div>`);
            html = html.concat(`<div class="page-num page-num--next" data-page="${resp.items.next_page}"><em class="icon-arrow-right"></em></div>`);
            $pagination.html(html);
          }
          // disable next button
          if (Number(resp.items.current_page) === Number(resp.items.total_pages)) {
            $pagination.find('.page-num--next, .page-num--current').addClass('disabled');
          }
        }

        $noResult.remove();

        if (resp.items.total_pages === 0) {
          $courseList.append(`<p class="no-result">${resp.items.message}</p>`);
        } else {
          $noResult.remove();
        }
      }
    } catch (error) {
      console.error(error);
    }

    $FilterBlock.loading(false);
    // $FilterForm.loading(false);
    // this.$FilterBlock.removeClass('loading');
  }

  handlePagination() {
    const _this = this;
    $(document).on('click', '#pagination-filter-shorties .page-num', function () {
      this.formData = {
        ...this.formData,
        page: $(this).data('page'),
      };
      _this.loadTraningListShorties(this.formData);
    });
  }
}

export default FilterShorties;
