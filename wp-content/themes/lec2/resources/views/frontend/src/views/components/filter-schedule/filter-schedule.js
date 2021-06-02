import { eliComponent } from '@/@core/web/eli-component';
import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';

/**
 *
 *
 * @class FilterShorties
 */
@eliComponent({
  selector: '.js-filter-schedule-form',
})
class FilterShorties extends AbstractController {
  selfClass = '.filter-schedule-form';

  /**
   * Main init schedule form
   */
  main() {
    this.$FilterBlock = $('.filter-schedule-form');
    this.$FilterForm = this.$FilterBlock.find('form');
    this.formData = { posts_per_page: 10 };
    const $typeId = $('#type_select');

    $('#fromDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
    });

    $('#toDatepicker').datepicker({
      uiLibrary: 'bootstrap4',
    });

    const $location = $('.location');
    const $datePicker = $('.date-picker');
    const $keyword = $('.keyword');

    $location.hide();
    $datePicker.hide();
    $keyword.hide();

    $typeId.on('change', function () {
      const optionSelected = $(this).find('option:selected');
      const textSelected = optionSelected.val();
      if (textSelected === 'location') {
        $location.show();
        $datePicker.hide();
        $keyword.hide();
      }

      if (textSelected === 'date') {
        $datePicker.show();
        $location.hide();
        $keyword.hide();
      }

      if (textSelected === 'type') {
        $keyword.show();
        $location.hide();
        $datePicker.hide();
      }

      if (textSelected === 'all') {
        $location.hide();
        $datePicker.hide();
        $keyword.hide();
      }
    });

    this.$scope.courseListSchedule = {
      items: [],
    };

    this.loadTraningListSchedule({ type_id: 'all' });
    this.initFilterFormSchedule();
    this.handlePaginationSchedule();
  }

  /**
   * init filter form
   */
  initFilterFormSchedule() {
    const { $FilterForm } = this;

    $FilterForm.formValidator({
      schema: (yup) => {
        return {
          keyword: yup.mixed(),
        };
      },
      onSuccess: async ({ data, form }) => {
        data.page = 1;
        this.loadTraningListSchedule(data);
      },
    });
  }

  async loadTraningListSchedule(formData) {
    const { $FilterForm, $FilterBlock } = this;
    const $courseBlock = $('.filter-schedule-form');
    const $courseList = $('#scheduleForm .course-item-listing');
    const $noResult = $('.no-result');

    $FilterBlock.loading(true);
    // $FilterForm.loading(true);
    // $courseBlock.addClass('loading');

    switch (formData && formData.type_id) {
      case 'location':
        delete formData.from;
        delete formData.to;
        delete formData.keyword;
        break;
      case 'date':
        delete formData.location_id;
        delete formData.keyword;
        break;
      case 'type':
        delete formData.from;
        delete formData.to;
        delete formData.location_id;
        break;
      case 'all':
        delete formData.from;
        delete formData.to;
        delete formData.location_id;
        delete formData.keyword;
        break;
      default:
        break;
    }
    this.formData = {
      ...formData,
      posts_per_page: 10,
    };

    try {
      const resp = await AjaxService.getInstance().sendScheduleCourse(this.formData, {
        noMessage: true,
      });

      if (resp) {
        this.$scope.courseListSchedule = {
          items: [...resp.items.data],
        };

        const $pagination = $('#pagination-schedule');
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
    // $courseBlock.removeClass('loading');
  }

  handlePaginationSchedule() {
    const _this = this;
    $(document).on('click', '#pagination-schedule .page-num', function () {
      _this.formData = {
        ..._this.formData,
        page: $(this).data('page'),
      };

      _this.loadTraningListSchedule(_this.formData);
    });
  }
}

export default FilterShorties;
