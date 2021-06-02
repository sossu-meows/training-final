import * as yup from 'yup';


const isRequired = (field) => {
  return field.tests && field.tests.find(e => e.OPTIONS && e.OPTIONS.name === 'required');
};

/* eslint-disable no-template-curly-in-string */
/**
 * See https://github.com/jquense/yup for validate api
 */

yup.addMethod(yup.mixed, 'sameAs', function sameAs(ref, refName, message) {
  return this.test({
    name: 'sameAs',
    message: message || '${path} must be the same as ${reference}',
    params: {
      reference: refName || ref,
    },
    test(value) {
      const other = this.resolve(yup.ref(ref));
      return !other || !value || value === other;
    },
  });
});

yup.common = {
  checkbox: () => yup.number().transform(value => (value ? 1 : 0)),
  requiredCheck: () => yup.boolean().oneOf([true], '${path} must be checked'),
  integer: (message = '${path} must be a integer number') =>
    yup
      .number()
      .typeError(message)
      .integer()
      .transform(v => (isNaN(v) ? undefined : v)),
  number: (message = '${path} is not valid') =>
    yup
      .number()
      .typeError(message)
      .integer()
      .transform(v => (isNaN(v) || v < 0 ? null : v)),
  string: (message = '${path} is a required field') =>
    yup
      .string()
      .typeError(message)
      .transform(value => (value.trim() ? value : null)),
  phoneNumber: () => yup.string()
    .transform(function (value) {
      value = value && value.replace(/ /g, '');
      return !!value || isRequired(this) ? value : ' ';
    })
    .matches(/^([\d-+]+)| $/, '${path} is invalid'),
  zipCode: () => yup.string()
    .test('len', 'Must be exactly 5 characters', val => val.length === 5),
};

export default yup;
