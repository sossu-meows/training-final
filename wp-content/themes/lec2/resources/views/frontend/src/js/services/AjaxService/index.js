import AbstractAjax from './abstract/abstract-ajax';
import { makeSingleton } from '../../common/helpers/functions';
import partnerData from './MockData/partners.json';
import posts from './MockData/posts.json';
import coursesList from './MockData/coursesList.json';
import shortiesList from './MockData/shortiesList.json';
import scheduleList from './MockData/scheduleList.json';

const ACTIONS = {
  sendContact: {
    method: 'POST',
    actionName: 'send_contact',
  },
  sendRequestACall: {
    method: 'POST',
    actionName: 'send_request_a_call',
  },

  sendRequestEmail: {
    method: 'POST',
    actionName: 'send_request_email',
  },
  sendPayment: {
    method: 'POST',
    actionName: 'send_payment',
  },
  sendOffer: {
    method: 'POST',
    actionName: 'send_offer',
  },
  sendFilterCourse: {
    method: 'POST',
    actionName: 'send_filter_course',
    // Mock ajax
    mocks(...params) {
      return {
        ...coursesList,
      };
    },
  },
  sendShortiesCourse: {
    method: 'POST',
    actionName: 'send_shorties_course',
    // Mock ajax
    mocks(...params) {
      return {
        ...shortiesList,
        show_load_more: true,
      };
    },
  },
  sendScheduleCourse: {
    method: 'POST',
    actionName: 'send_schedule_course',
    // Mock ajax
    mocks(...params) {
      return {
        ...scheduleList,
        show_load_more: true,
      };
    },
  },
  getMorePartner: {
    method: 'POST',
    actionName: 'get_more_partner',
    // Mock ajax
    mocks(...params) {
      return {
        show_load_more: true,
        data: partnerData,
      };
    },
  },
  getMorePost: {
    method: 'POST',
    actionName: 'get_more_post',
    // Mock ajax
    mocks(...params) {
      return {
        ...posts,
      };
    },
  },
};

/**
 * Find custom mock function by action name
 *
 * @export
 * @param {*} actionName
 * @returns
 */
export function findCustomMock(actionName) {
  const actionData = Object.values(ACTIONS).find((e) => {
    return e.actionName === actionName;
  });
  return actionData && actionData.mocks;
}

class AjaxService extends AbstractAjax {
  sendContact = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendContact,
      data: formData,
      ...options,
    });
  };

  sendPayment = (formData) => {
    return this._doSendRequest({
      action: ACTIONS.sendPayment,
      data: formData,
    });
  };

  sendOffer = (formData) => {
    return this._doSendRequest({
      action: ACTIONS.sendContact,
      data: formData,
    });
  };

  sendFilterCourse = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendFilterCourse,
      data: formData,
      ...options,
    });
  };

  sendShortiesCourse = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendShortiesCourse,
      data: formData,
      ...options,
    });
  };

  sendScheduleCourse = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendScheduleCourse,
      data: formData,
      ...options,
    });
  };

  sendRequestEmail = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendRequestEmail,
      data: formData,
      ...options,
    });
  };

  sendRequestACall = (formData, options) => {
    return this._doSendRequest({
      action: ACTIONS.sendRequestACall,
      data: formData,
      ...options,
    });
  };

  getMorePartner = (formData) => {
    return this._doSendRequest({
      action: ACTIONS.getMorePartner,
      data: formData,
    });
  };

  getMorePost = (formData) => {
    return this._doSendRequest({
      action: ACTIONS.getMorePost,
      data: formData,
    });
  };
}

makeSingleton(AjaxService);

export default AjaxService;
