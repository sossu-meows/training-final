/* eslint-disable import/no-webpack-loader-syntax */

import COLORS_CONTENT from '!!raw-loader!@/scss/base/_variables.scss';
import ICONS_CSS_CONTENT from '!!raw-loader!@/scss/icons/_icons-mixins.scss';
import { mockDelay, regexMap } from '@/js/common/helpers/functions';
import AbstractController from '@/@core/web/controllers/abstract';

class StyleGuideController extends AbstractController {
  main() {
    this.initColorList();
    this.initIconsInfo();
  }

  initColorList() {
    const pattern = /(.*?): (#.*?);/g;
    const pattern2 = /(.*?): (\$color.*?);/g;
    const colors = [];
    const mainColors = [];

    regexMap(COLORS_CONTENT, pattern, ([, name, hex]) => {
      colors.push({
        colorName: name,
        hex,
      });
    });

    regexMap(COLORS_CONTENT, pattern2, ([, name, colorName]) => {
      const hexColor = colors.find(e => e.colorName === colorName);
      if (hexColor) {
        mainColors.push({
          colorName: name,
          hex: hexColor.hex,
        });
      }
    });

    // /* Binding data to view */
    this.$scope.listColors = colors;
    this.$scope.listMainColors = mainColors;
  }

  initDemoForm() {
    const $demoForm = $('#demoForm');

    $demoForm.asyncPlugin().formValidator({
      schema: (yup) => {
        return {
          text1: yup
            .string()
            .required(),
          text2: yup
            .string()
            .required(),
          text3: yup
            .string()
            .required(),
          phone: yup
            .common
            .phoneNumber()
            .required()
            .label('Phone number'),
          password1: yup
            .string()
            .min(6)
            .required()
            .label('Password'),
          repeatedPassword: yup
            .string()
            .sameAs('password', 'Password')
            .required()
            .label('Re-Password'),
        };
      },
      onSuccess: async ({ data, form }) => {
        $demoForm.loading(true);
        try {
          mockDelay(1000);
          form.reset();
        } catch (error) {
          console.error(error);
        }
        $demoForm.loading(false);
      },
    });
  }

  initIconsInfo() {
    const pattern = /'(.*?)':.*?'(.*?)'/g;
    const matchers = ICONS_CSS_CONTENT.match(pattern);
    const icons = [];

    if (matchers) {
      matchers.forEach((str) => {
        pattern.lastIndex = 0;
        const [, name, content] = pattern.exec(str);
        icons.push({
          className: `icon-${name}`,
          content,
        });
      });
    }

    icons.sortBy('className');
    /* Binding data to view */
    this.$scope.listIcons = icons;
  }
}

export default StyleGuideController;

