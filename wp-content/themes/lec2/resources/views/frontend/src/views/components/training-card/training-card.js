import { eliComponent, AbstractComponent } from '@/@core/web/eli-component';

/**
 *
 *
 * @class TrainingCard
 */
@eliComponent({
  selector: '.js-training-card',
})
class TrainingCard extends AbstractComponent {
  init() {
    this.initTrainingType();
  }

  initTrainingType() {
    const $typeItem = $('.training-list .training-item');
    $.each($typeItem, (i) => {
      const $typeIndex = $typeItem[i].dataset.index;
      const $typeHref = $typeItem[i].href;
      const $targetLink = $typeHref + $typeIndex;

      $typeItem[i].href = $targetLink;
    });
  }
}

export default TrainingCard;
