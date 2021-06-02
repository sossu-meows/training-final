import AbstractController from '@/@core/web/controllers/abstract';
import AjaxService from '@/js/services/AjaxService';
import urlHelper from '@/js/common/helpers/url-helper';
import pagination from '@/js/plugins/theme-features/modules/pagination';


class TrainingsOverviewListingController extends AbstractController {
  main() {
    this.$scope.trainings = {
      courseList: {},
      category: {},
    };

    const params = urlHelper.getQuery();
    this.current_page = 1;

    this.$trainingBlock = $('.trainings-overview-content');
    this.$FilterForm = this.$trainingBlock.find('.filter-form form');

    this.setDefaultValue();
    this.loadTraningList(params);
    this.initFilterForm();
    this.handlePagination();
  }

  /**
   * Change limit value for mobile
   *
   * @memberof FilterForm
   */
  setDefaultValue() {
    const $search = this.$FilterForm.find('input[name="search"]');
    const $categoryType = this.$FilterForm.find('select[name="training_type_id"]');
    const $category = this.$FilterForm.find('select[name="training_cat_id"]');
    const params = urlHelper.getQuery();

    if (params) {
      if (params.search) {
        $search.val(params.search);
      }

      if (params.training_type_id) {
        $categoryType.selectpicker('val', params.training_type_id);
      }

      if (params.training_cat_id) {
        $category.selectpicker('val', params.training_cat_id);
      }

      if (params.page) {
        this.current_page = params.page;
      }
    }
  }

  /**
   * init filter form
   */
  initFilterForm() {
    const { $FilterForm } = this;

    $FilterForm.formValidator({
      schema: (yup) => {
        return {
          search: yup.mixed(),
        };
      },
      onSuccess: async ({ data, form }) => {
        const query = urlHelper.getQuery();
        urlHelper.removeQuery(query);
        urlHelper.appendQuery(data);
        this.loadTraningList(data);
      },
    });
  }

  async loadTraningList(formData) {
    const _this = this;
    const { $FilterForm } = this;
    const $courseBlock = $('.course-listing-block');
    const $courseContent = $('.trainings-overview-content');
    const $filterBlock = $('.filter-block');
    const $courseListing = $('.course-listing');
    const $noResult = $('.no-result');

    const posts_per_page = global.viewport.isMobile ? 3 : 10;

    $courseContent.loading(true);

    formData = {
      ...formData,
      posts_per_page,
    };

    try {
      const resp = await AjaxService.getInstance().sendFilterCourse(formData, {
        noMessage: true,
      });

      if (resp) {
        this.$scope.trainings = {
          courseList: resp.trainings.data,
          category: resp.category,
        };
        const dataTrainings = resp.trainings;

        const $pagination = $('#pagination-container');
        $pagination.html('');
        if (dataTrainings.total_pages > 1) {
          const htmlPagination = pagination(Number(dataTrainings.total_pages), Number(dataTrainings.current_page), `${document.location.host}${document.location.pathname}`, 4);
          $pagination.html(htmlPagination);

          this.current_page = dataTrainings.current_page;
        }

        $noResult.remove();
        $courseListing.removeClass('no-result-wrapper');

        if (dataTrainings.total_pages === 0) {
          $courseListing.addClass('no-result-wrapper');
          $courseListing.append(`<p class="no-result">${dataTrainings.message}</p>`);
        } else {
          $noResult.remove();
          $courseListing.removeClass('no-result-wrapper');
        }
      }
    } catch (error) {
      console.error(error);
    }

    $courseContent.loading(false);
    $filterBlock.addClass('all-loaded');
    $courseBlock.addClass('all-loaded');
  }
  /**
 * handlePagination on click
 * Hot fix when next & prev page number is 0
 * @memberof TrainingsOverviewListingController
 */
  handlePagination() {
    $(document).on('click', '#pagination-container .page-number', (e) => {
      e.preventDefault();
      const page = Number(e.target.dataset.page);

      urlHelper.appendQuery({
        page,
      });
      this.loadTraningList(urlHelper.getQuery());
    });
  }
}

export default TrainingsOverviewListingController;
