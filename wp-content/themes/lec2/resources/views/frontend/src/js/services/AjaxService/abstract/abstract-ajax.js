import { convertToMultipartForm } from './functions';
import { findCustomMock } from '../../AjaxService';

const MOCK_DELAY = 1500;

const AJAX_CONTENT_TYPES = {
  data: 'application/x-www-form-urlencoded; charset=UTF-8',
  upload: false,
  json: 'application/json',
};

const defaultRequestParams = {
  isUpload: true,
};

export default class AbstractAjax {
  constructor() {
    this.ajaxUrl = global.APP_CONFIG.wpConfig.ajaxUrl;
  }

  _doSendRequest = async (params) => {
    params = {
      ...defaultRequestParams,
      ...params,
    };

    const query = `?action=${encodeURIComponent(params.action.actionName)}`;
    const ajaxOptions = {
      method: params.action.method,
      contentType: AJAX_CONTENT_TYPES.json,
      data: JSON.stringify(params.data),
      url: params.action.url || `${this.ajaxUrl}${query}`,
    };

    if (params.isUpload && params.action.method.toUpperCase() !== 'GET') {
      ajaxOptions.contentType = AJAX_CONTENT_TYPES.upload;
      ajaxOptions.data = convertToMultipartForm(params.data);
      ajaxOptions.processData = false;
    }

    if (global.APP_CONFIG.wpConfig.isMock) {
      return this._mockRequest(params);
    }

    try {
      const resp = await $.ajax(ajaxOptions);
      return this._handleResponse(resp, params);
    } catch (error) {
      // Not bussiness error
      if (!error.message) {
        global.toast.error(`Request responsed ${error.status}`);
      }
      throw error;
    }
  }

  _handleResponse(resp, params) {
    if (resp.status === 200 || resp.status === true) {
      if (params.noMessage !== true) {
        global.toast.success(resp.message);
      }
      return resp;
    } else if (resp.message) {
      if (params.noMessage !== true) {
        global.toast.error(resp.message);
      }
      throw resp;
    }
    return resp;
  }

  /**
   * Mock request ajax, help frontend to test/implement UI
  */
  _mockRequest = (params) => {
    const { action, data } = params;
    return new Promise((resolve) => {
      // Simple mocks
      let resp = {
        status: true,
        message: 'Requested successfully',
      };
      const mocksFunction = findCustomMock(action.actionName);
      if (mocksFunction) {
        resp = mocksFunction(params);
      }

      setTimeout(() => {
        resolve(resp);
        this._handleResponse(resp, params);
        console.log('%cMOCK AJAX:', 'color:red;font-weight:bold;', { resp, action, data });
      }, MOCK_DELAY);
    });
  }
}
