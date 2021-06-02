/* eslint-disable */
import { map } from '@/js/common/helpers/functions';
import yupBase from '../modules/yup';

/**
 * From schema we generate field watchers for validating a field when its value is changing
 * @param {*} model: schema of the form
 * @param {*} stateName: name of the form data in our component's state
 */
export const generateFieldWatchers = (model, stateName = 'form') => {
  const res = {};
  map(model, (field, key) => {
    const watcherName = `${stateName}.${key}`;
    res[watcherName] = function watcher(newValue, oldValue) {
      this.validateField(key);
    };
  });
  return res;
};

export const parseFormData = form => {
  if (!form || form.nodeName !== 'FORM') {
    return;
  }
  let i,
    j,
    q = [],
    arrayFields = [];
  for (i = form.elements.length - 1; i >= 0; i--) {
    if (form.elements[i].name === '') {
      continue;
    }
    switch (form.elements[i].nodeName) {
      case 'INPUT':
        switch (form.elements[i].type) {
          case 'number':
            try {
              q.push([form.elements[i].name, parseFloat(form.elements[i].value)]);
            } catch (err) {
              console.error(err);
            }
            break;
          case 'text':
          case 'tel':
          case 'email':
          case 'hidden':
          case 'password':
          case 'button':
          case 'reset':
          case 'submit':
          case 'duration_format':
          case 'input_mask':
            q.push([form.elements[i].name, form.elements[i].value]);
            break;
          case 'checkbox':
            if (form.elements[i].checked) {
              let value = form.elements[i].value;
              value = value === 'on' ? 1 : value === 'off' ? 0 : value;
              q.push([form.elements[i].name, value]);
            } else {
              q.push([form.elements[i].name, 0]);
            }
            break;
          case 'radio':
            if (form.elements[i].checked) {
              q.push([form.elements[i].name, form.elements[i].value]);
            }
            break;
          case 'file':
            const { files, multiple } = form.elements[i];
            if (files) {
              Array.from(files).forEach(e => q.push([form.elements[i].name, e]));
            }
            if (multiple) {
              arrayFields.push(form.elements[i].name);
            }
            break;
        }
        break;
      case 'TEXTAREA':
        q.push([form.elements[i].name, form.elements[i].value]);
        break;
      case 'SELECT':
        switch (form.elements[i].type) {
          case 'select-one':
            q.push([form.elements[i].name, form.elements[i].value]);
            break;
          case 'select-multiple':
            for (j = form.elements[i].options.length - 1; j >= 0; j--) {
              if (form.elements[i].options[j].selected) {
                q.push([form.elements[i].name, form.elements[i].options[j].value]);
              }
            }
            break;
        }
        break;
      case 'BUTTON':
        switch (form.elements[i].type) {
          case 'reset':
          case 'submit':
          case 'button':
            q.push([form.elements[i].name, form.elements[i].value]);
            break;
        }
        break;
    }
  }
  const res = {};
  for (const [key, val] of q) {
    if (res[key] === undefined) {
      res[key] = arrayFields.includes(key) ? [val] : val;
    } else if (Array.isArray(res[key])) {
      res[key].push(val);
    } else {
      res[key] = [res[key]];
      res[key].push(val);
    }
  }
  return res;
};

export const applyFormData = (form, data) => {
  let input = null;
  let val = null;
  if (form && data) {
    Object.keys(data).map(key => {
      input = form[key];
      val = data[key];
      if (input) {
        if (input.type === 'checkbox' || input.type === 'radio') {
          input.checked = !!val;
        } else if (input.nodeName === 'SELECT') {
          input.value = val;
        } else {
          input.value = val;
        }
      }
      return null;
    });
  }
  return this;
};

export function yupPluginLoader() {
  return Promise.resolve(yupBase);
}

export const validate = async (formData, context) => {
  let {formSchema, yup} = context;

  formSchema = yup.object().shape(formSchema);

  const res = {
    errors: null,
    data: null,
  };
  try {
    formSchema.validateSync(formData, {
      abortEarly: false,
      stripUnknown: true,
    });
    res.data = formSchema.cast(formData);
  } catch (err) {
    if (err.inner) {
      res.errors = {};
      err.inner.map(e => {
        res.errors[e.path] = e.errors;
        return null;
      });
    } else {
      console.error(err);
    }
  }
  return res;
};

export const isValid = (formData, fromSchema) => {
  return !validate(formData, fromSchema).errors;
};
