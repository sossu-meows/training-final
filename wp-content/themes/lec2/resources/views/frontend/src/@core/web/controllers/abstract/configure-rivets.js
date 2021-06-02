/* eslint-disable eqeqeq */
// eslint-disable-next-line import/no-extraneous-dependencies
import rivets from 'rivets';

/** Configure the rivets object */
rivets.configure({

  // Attribute prefix in templates
  prefix: 'rv',

  // Preload templates with initial data on bind
  preloadData: true,

  // Root sightglass interface for keypaths
  rootInterface: '.',

  // Template delimiters for text bindings
  templateDelimiters: ['{', '}'],

  // Alias for index in rv-each binder
  iterationAlias(modelName) {
    return `%${modelName}%`;
  },

  // Augment the event handler of the on-* binder
  handler(target, event, binding) {
    this.call(target, event, binding.view.models);
  },

  // Since rivets 0.9 functions are not automatically executed in expressions. If you need backward compatibilty, set this parameter to true
  executeFunctions: true,

});

/**
Define all rivets formater, you can define more formaters here
*/
rivets.formatters['=='] = function (value, arg) {
  return value == arg;
};

rivets.formatters['==='] = function (value, arg) {
  return value === arg;
};

rivets.formatters['>'] = function (value, arg) {
  return value > arg;
};

rivets.formatters['>='] = function (value, arg) {
  return value >= arg;
};

rivets.formatters['<'] = function (value, arg) {
  return value < arg;
};

rivets.formatters['<='] = function (value, arg) {
  return value <= arg;
};

rivets.formatters['+'] = function (value, arg) {
  return value + arg;
};

rivets.formatters['-'] = function (value, arg) {
  return value - arg;
};

rivets.formatters.concat = function (value, arg) {
  const a = value;
  const b = arg;

  return (a || '') + (b || '');
};

rivets.binders['set-class'] = function (el, value) {
  el.className += ` ${value}`;
};

rivets.binders['background-color'] = function (el, value) {
  el.style.backgroundColor = value;
};

rivets.formatters.isEmpty = function (value) {
  return (typeof value === 'undefined' || value === null || value === false || (typeof value === 'string' && value.length === 0));
};

rivets.formatters.isNotEmpty = function (value) {
  return !rivets.formatters.isEmpty(value);
};

export default rivets;
