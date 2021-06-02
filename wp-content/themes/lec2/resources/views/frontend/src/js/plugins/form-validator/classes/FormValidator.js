import { map } from '@/js/common/helpers/functions';
import { parseFormData, validate, applyFormData, yupPluginLoader } from '../modules/helper';

export default class FormValidator {
  $form = null;
  loading = false;
  errors = null;

  static defaultProps = {
    onSuccess: () => { },
    onError: () => { },
    onFieldError: () => { },
    autoAddLabel: false,
  };

  constructor(element, props = FormValidator.defaultProps) {
    this.props = props;
    this.$form = $(element);
    this.formElement = this.$form.get(0);
    this.init();
  }

  init = async () => {
    await this._initYupSchema();
    const { $form } = this;
    const fieldsSelector = '.form-control, input, select';
    const fieldChangeEvents = 'change keyup';
    $form.on('submit', this.onSubmit);
    $form.on('reset', () => {
      this.resetErrorState();
    });
    $form.on(fieldChangeEvents, fieldsSelector, this.onFieldChange);

    this.removeEvents = () => {
      $form.on('submit', this.onSubmit);
      $form.off(fieldChangeEvents, fieldsSelector, this.onFieldChange);
    };
    $form.addClass('form-validator-loaded');
    this.$emit('ready');
  }

  reset = () => {
    this.$form[0].reset();
  }

  _optimizeFormSchema() {
    // Remove browser validate
    const { formSchema, $form, props } = this;
    const $controls = $form.find('[name], input');
    $controls.each((idz, e) => {
      const $control = $(e);
      const name = $control.attr('name');
      const fieldSchema = formSchema[name];
      const label = $control.siblings('label').text();

      if ($control.attr('required')) {
        $control.removeAttr('required');
      }

      if (fieldSchema) {
        if (props.autoAddLabel && label) {
          formSchema[name] = fieldSchema.label(label);
        } else if (!fieldSchema._label) {
          fieldSchema._label = 'This';
        }
      }
    });
  }

  async _initYupSchema() {
    const yup = await yupPluginLoader();
    this.formSchema = this.props.schema(yup, this);
    this.yup = yup;
    this._optimizeFormSchema();
  }

  $emit(eventName, data) {
    const { props } = this;
    const {
      onSuccess, onError, onFieldError, onReady,
    } = props;
    switch (eventName) {
      case 'ready':
        if (onReady) {
          onReady({ form: this });
        }
        break;
      case 'error':
        if (onError) {
          onError({ errors: data, form: this });
        }
        break;
      case 'success':
        if (onSuccess) {
          onSuccess({ data, form: this });
        }
        break;
      case 'fieldError':
        if (onFieldError) {
          onFieldError({ fieldErrors: data, form: this });
        }
        break;
      default:
        break;
    }
  }

  destroy = () => {
    if (this.removeEvents) {
      this.removeEvents();
    }
  }

  onSubmit = async (event) => {
    event.preventDefault();
    if (!this.loading) {
      const res = await this.validate();
      if (!res.errors) {
        this.$emit('success', res.data);
      }
    }
  }

  onFieldChange = (event) => {
    const { name } = event.target;
    if (name) {
      this.validateField(name);
    }
  }

  validateField = async (name) => {
    await this._initYupSchema();
    const res = await validate(this.getData(), this);
    const fieldError = res.errors ? res.errors[name] : null;
    this.errors = {
      ...this.errors,
    };
    if (fieldError) {
      this.errors[name] = fieldError;
      this.$emit('error', this.errors);
      this.$emit('fieldError', { name, error: fieldError });
    } else {
      delete this.errors[name];
    }
    this.showErrors();
  }

  getData = () => {
    return parseFormData(this.formElement);
  }

  validate = async () => {
    await this._initYupSchema();
    const res = await validate(this.getData(), this);
    this.errors = res.errors || {};
    if (res.errors) {
      this.$emit('error', this.errors);
      this.showErrors();
    }
    return res;
  }

  setData = (formData) => {
    applyFormData(this.formElement, formData);
  }

  resetErrorState() {
    const { $form } = this;
    $form.find('.form-field.active').removeClass('active');
    $form.find('.invalid-feedback').remove();
    $form.find('.has-error').removeClass('has-error');
    $form.find('.is-invalid').removeClass('is-invalid');
  }

  showErrors = () => {
    const { $form } = this;
    this.resetErrorState();

    map(this.errors, (value, key) => {
      if (value) {
        const $control = $form.find(`[name="${key}"]`).eq(0);
        let $parent = $control.closest('.form-group');
        $parent = $parent.length ? $parent : $control.parent();
        if ($control.length) {
          $parent.addClass('has-error');
          $control.addClass('is-invalid');
          $parent.append(`<div class="invalid-feedback">${value.map(message => `<span>${message}</span>`).join('')}</div>`);
        } else {
          console.error(`Field name ${key} not found`);
        }
      }
    });
  }
}
