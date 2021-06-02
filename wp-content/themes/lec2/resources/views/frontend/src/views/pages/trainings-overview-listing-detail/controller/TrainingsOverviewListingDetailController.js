import AbstractController from '@/@core/web/controllers/abstract';
import urlHelper from '@/js/common/helpers/url-helper';

class TrainingsOverviewListingDetailController extends AbstractController {
  main() {
    this.initTrainingTabs();
    this.handleSelectExecutionOfTraining();
  }

  initTrainingTabs() {
    const $trainingCard = $('.training-type');

    if ($trainingCard.length) {
      $trainingCard.on('click', function () {
        const getDataTarget = $(this).attr('data-target');
        const typeIndex = $(this).data('index');

        $trainingCard.removeClass('selected');
        $(this).addClass('selected');
        $('.training-body .training-container').removeClass('show');
        $(`.training-body ${getDataTarget}`).addClass('show');
        $('.agenda-block .container').removeClass('show');
        $(`.agenda-block ${getDataTarget}`).addClass('show');

        // Set index to url
        urlHelper.appendQuery({
          type: typeIndex,
        });
      });

      // Type index from url
      const urlTypeIndex = urlHelper.getQuery().type;
      const $targetCard = $(`.training-type[data-index="${urlTypeIndex}"]`);

      if ($targetCard.length) {
        $targetCard.click();
      } else {
        $trainingCard[0].click();
      }
    }
  }
  handleSelectExecutionOfTraining() {
    const $executionOfTraining = $('.training-container [name="execution_of_training"]');
    const $handleExecutionOfTrainingSelect = $('.training-container [name="executionOfTrainingSelect"]');

    // set training_type_id value for form
    $executionOfTraining.each((index, field) => {
      const $trainingContainer = $(field).closest('.training-container');
      const $selected = $trainingContainer.find('[name="executionOfTrainingSelect"]');
      const $buyBtn = $trainingContainer.find('.btn-buy-training');
      const $noTime = $trainingContainer.find('.no_time_select');
      if ($selected.length) {
        const eValue = $selected.val();
        $(field).val(eValue);
        if (eValue === 'live_video' && $noTime.length) {
          $buyBtn.addClass('hidden');
        } else {
          $buyBtn.remove('hidden');
        }
      }
    });

    // handle on executionOfTraining change
    $handleExecutionOfTrainingSelect.on('changed.bs.select', (e, clickedIndex, isSelected) => {
      const val = $(e.target).val();
      const $trainingContainer = $(e.target).closest('.training-container');
      const $format = $trainingContainer.find('.training-body-row--format');
      const $rowDates = $trainingContainer.find('.training-body-row--date');
      const $rowDuration = $trainingContainer.find('.training-body-row--duration');
      const $fieldTrainingTypeIdOfForm = $trainingContainer.find('[name="execution_of_training"]');
      const $cost = $trainingContainer.find('.cost-value');
      const $trainingInput = $trainingContainer.find('[name="training_url"]');
      const $timeSelect = $trainingContainer.find('[name="time_select"]');
      const $timeInput = $trainingContainer.find('[name="time"]');
      const $timeInputDefault = $trainingContainer.find('[name="time_default"]');
      const $buyBtn = $trainingContainer.find('.btn-buy-training');
      const $noTime = $trainingContainer.find('.no_time_select');

      if (val === 'live_video') {
        $format.removeClass('hidden');
        $rowDates.removeClass('hidden');
        $rowDuration.removeClass('hidden');
        $timeInput.val($timeSelect.val());
        if ($noTime.length) {
          $buyBtn.addClass('hidden');
        }
      } else {
        $format.addClass('hidden');
        $rowDates.addClass('hidden');
        $rowDuration.addClass('hidden');
        $timeInput.val($timeInputDefault.val());
        $buyBtn.removeClass('hidden');
      }
      $fieldTrainingTypeIdOfForm.val(val);
      const $selectOption = $(e.target).find('option').eq(clickedIndex);
      const costValue = $selectOption.data('cost');
      $cost.text(costValue);

      const trainingUrlValue = $selectOption.data('url');
      $trainingInput.val(trainingUrlValue);
    });

    // handle on date change
    $(document).on('change', '[name="time_select"]', function () {
      const val = this.value;
      const $trainingContainer = $(this).closest('.training-container');
      const $fieldDateOfForm = $trainingContainer.find('[name="time"]');
      if ($fieldDateOfForm) {
        $fieldDateOfForm.val(val);
      }
    });
  }
}

export default TrainingsOverviewListingDetailController;
