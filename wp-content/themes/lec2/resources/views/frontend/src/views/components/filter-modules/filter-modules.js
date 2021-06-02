import { eliComponent } from '@/@core/web/eli-component';
import AbstractController from '@/@core/web/controllers/abstract';
import urlHelper from '@/js/common/helpers/url-helper';

/**
 *
 *
 * @class FilterModules
 */
@eliComponent({
  selector: '.js-filter-modules-form',
})
class FilterModules extends AbstractController {
  selfClass = '.filter-modules-form';

  /**
   * Main init filter map
   */
  main() {
    this.$FilterBlock = $('.filter-modules-form');
    this.$FilterForm = this.$FilterBlock.find('form');
    this.setDefaultValue();
  }

  setDefaultValue() {
    const $categoryType = this.$FilterForm.find('select[name="training_type_id"]');
    const $category = this.$FilterForm.find('select[name="training_cat_id"]');
    const params = urlHelper.getQuery();

    if (params) {
      if (params.training_cat_id) {
        $category.selectpicker('val', params.training_cat_id);
      }

      if (params.training_type_id) {
        $categoryType.selectpicker('val', params.training_type_id);
      }
    }
  }
}

export default FilterModules;
