export default class _AbstractComponent {
  // Component options
  options = {};

  // To contain element
  $element = null;

  // class of element
  selfClass = '.abstract-component';

  constructor(element, options) {
    this.$element = $(element);
    this.options = options;
  }

  /**
   * Set component options
   * @param {object} options component options
   */
  setOptions(options) {
    this.options = options;
    this.onOptionsChanged(options);
  }


  /**
   * Optops
   * @param {object} options component options
   */
  onOptionsChange(options) {
    // Allow hook options changes
  }

  destroy() {
    // Destroy component
  }

  init() {
    throw new Error('Abstract Component init');
  }

  /**
   * get child element by BEM name
   *
   * @param {*} name
   * @returns {JqueryElement} element
   */
  findBEM(name) {
    if (!this.selfClass) {
      throw new Error('To use findBEM please declare this.selfClass');
    }
    return this.$element.find(`${this.selfClass}__${name}`);
  }


  /**
   * get child element
   *
   * @param {*} name
   * @returns {object} element
   */
  find(name) {
    // is BEM selector
    return this.$element.find(name);
  }
}
