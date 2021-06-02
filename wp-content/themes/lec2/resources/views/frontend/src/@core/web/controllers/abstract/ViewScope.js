/* eslint-disable eqeqeq */
import { makeSingleton } from '@/js/common/helpers/functions';
import rivets from './configure-rivets';

class ViewScope {
  // component's view scope
  data = {};

  constructor() {
    this.$body = $('body');
    // Start binding data by using rivets
    rivets.bind(this.$body, this.data);
  }

  setViewMethods(source) {
    const methods = {};
    // Get all function of the instance
    const properties = Object.getOwnPropertyNames(source.constructor.prototype).concat(Object.getOwnPropertyNames(source));
    properties.forEach((key) => {
      const value = source[key];
      if (key !== 'constructor' && typeof value === 'function') {
        methods[key] = value.bind(source);
      }
    });
    Object.assign(this.data, methods);
  }

  setViewData(data) {
    Object.assign(this.data, data);
  }
}

makeSingleton(ViewScope);

export default ViewScope;
