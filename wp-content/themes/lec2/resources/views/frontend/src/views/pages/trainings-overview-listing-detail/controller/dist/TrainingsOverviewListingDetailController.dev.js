"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _abstract = _interopRequireDefault(require("@/@core/web/controllers/abstract"));

var _urlHelper = _interopRequireDefault(require("@/js/common/helpers/url-helper"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

var TrainingsOverviewListingDetailController =
/*#__PURE__*/
function (_AbstractController) {
  _inherits(TrainingsOverviewListingDetailController, _AbstractController);

  function TrainingsOverviewListingDetailController() {
    _classCallCheck(this, TrainingsOverviewListingDetailController);

    return _possibleConstructorReturn(this, _getPrototypeOf(TrainingsOverviewListingDetailController).apply(this, arguments));
  }

  _createClass(TrainingsOverviewListingDetailController, [{
    key: "main",
    value: function main() {
      this.initTrainingTabs();
      this.handleSelectExecutionOfTraining();
    }
  }, {
    key: "initTrainingTabs",
    value: function initTrainingTabs() {
      var $trainingCard = $('.training-type');

      if ($trainingCard.length) {
        $trainingCard.on('click', function () {
          var getDataTarget = $(this).attr('data-target');
          var typeIndex = $(this).data('index');
          $trainingCard.removeClass('selected');
          $(this).addClass('selected');
          $('.training-body .training-container').removeClass('show');
          $(".training-body ".concat(getDataTarget)).addClass('show');
          $('.agenda-block .container').removeClass('show');
          $(".agenda-block ".concat(getDataTarget)).addClass('show'); // Set index to url

          _urlHelper["default"].appendQuery({
            type: typeIndex
          });
        }); // Type index from url

        var urlTypeIndex = _urlHelper["default"].getQuery().type;

        var $targetCard = $(".training-type[data-index=\"".concat(urlTypeIndex, "\"]"));

        if ($targetCard.length) {
          $targetCard.click();
        } else {
          $trainingCard[0].click();
        }
      }
    }
  }, {
    key: "handleSelectExecutionOfTraining",
    value: function handleSelectExecutionOfTraining() {
      var $executionOfTraining = $('.training-container [name="execution_of_training"]');
      var $handleExecutionOfTrainingSelect = $('.training-container [name="executionOfTrainingSelect"]'); // set training_type_id value for form

      $executionOfTraining.each(function (index, field) {
        var $trainingContainer = $(field).closest('.training-container');
        var $selected = $trainingContainer.find('[name="executionOfTrainingSelect"]');

        if ($selected.length) {
          $(field).val($selected.val());
        }
      }); // handle on executionOfTraining change

      $handleExecutionOfTrainingSelect.on('changed.bs.select', function (e, clickedIndex, isSelected) {
        var val = $(e.target).val();
        var $trainingContainer = $(e.target).closest('.training-container');
        var $format = $trainingContainer.find('.training-body-row--format');
        var $rowDates = $trainingContainer.find('.training-body-row--date');
        var $rowDuration = $trainingContainer.find('.training-body-row--duration');
        var $fieldTrainingTypeIdOfForm = $trainingContainer.find('[name="execution_of_training"]');
        var $cost = $trainingContainer.find('.cost-value');
        var $trainingInput = $trainingContainer.find('[name="training_url"]');
        var $timeSelect = $trainingContainer.find('[name="time_select"]');
        var $timeInput = $trainingContainer.find('[name="time"]');
        var $timeInputDefault = $trainingContainer.find('[name="time_default"]');

        if (val === 'live_video') {
          $format.removeClass('hidden');
          $rowDates.removeClass('hidden');
          $rowDuration.removeClass('hidden');
          $timeInput.val($timeSelect.val());
        } else {
          $format.addClass('hidden');
          $rowDates.addClass('hidden');
          $rowDuration.addClass('hidden');
          $timeInput.val($timeInputDefault.val());
        }

        $fieldTrainingTypeIdOfForm.val(val);
        var $selectOption = $(e.target).find('option').eq(clickedIndex);
        var costValue = $selectOption.data('cost');
        $cost.text(costValue);
        var trainingUrlValue = $selectOption.data('url');
        $trainingInput.val(trainingUrlValue);
      }); // handle on date change

      $(document).on('change', '[name="time_select"]', function () {
        var val = this.value;
        var $trainingContainer = $(this).closest('.training-container');
        var $fieldDateOfForm = $trainingContainer.find('[name="time"]');

        if ($fieldDateOfForm) {
          $fieldDateOfForm.val(val);
        }
      });
    }
  }]);

  return TrainingsOverviewListingDetailController;
}(_abstract["default"]);

var _default = TrainingsOverviewListingDetailController;
exports["default"] = _default;