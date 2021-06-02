import { ALL_PAGES } from '@/@core/builder/modules/html';
import { onResize } from '@/js/common/helpers/dom/resize';
import AbstractController from '@/@core/web/controllers/abstract';

const RELEASED_PAGES = [
  'home',
];

const DEV_PAGES = [
  'sitemap',
  'style-guide',
];

const IN_PROGRESS_PAGES = [
  'style-guide',
];


class SitemapController extends AbstractController {
  main() {
    this.initPreviewPageCards();
    this.initResponsiveControls();
  }

  initResponsiveControls() {
    const screenSizes = [
      {
        title: 'Mobile',
        width: 375,
        ratio: 6 / 9,
      },
      {
        title: 'Tablet',
        width: 768,
        ratio: 5 / 6,
      },
      {
        title: 'Desktop',
        width: 1440,
        ratio: 4 / 3,
      },
    ];

    this.$scope.screen = {
      current: screenSizes[2],
      list: screenSizes,
    };
    this.showPreviewDevice();
  }

  /**
   * Handle on device click
   */
  onDeviceClick(event, { device }) {
    this.$scope.screen.current = device;
    this.showPreviewDevice();
  }

  /**
   * Show preview for current device
   */
  showPreviewDevice() {
    const { width, ratio } = this.$scope.screen.current;
    $('.page-card iframe').each((index, item) => {
      const $iframe = $(item);
      const $preview = $iframe.parent();

      $preview.css({
        paddingBottom: `${100 / ratio}%`,
      });

      $iframe.css({
        width: `${width}px`,
        height: `${width / ratio}px`,
      });
    });
    requestAnimationFrame(this.fixPageCardSize.bind(this));
  }

  /**
   * init preview cards
   */
  initPreviewPageCards() {
    this.getListPages();
    let pages = this.mainPages;

    if (APP_CONFIG.development || ['.docker.elidev.info', '.local'].find(devSite => location.href.includes(devSite))) {
      pages = pages.concat(this.devPages);
    }

    this.$scope.mainPages = pages.map((e, index) => {
      const name = e.toCapitalize().replace(/-/g, ' ');
      return {
        id: index + 1,
        name,
        href: `${e}.html`,
        isInProgress: IN_PROGRESS_PAGES.includes(e),
      };
    });

    setTimeout(this.fixPageCardSize.bind(this), 100);
    onResize(this.fixPageCardSize.bind(this));
  }

  /**
   * Calculate page card size
   */
  fixPageCardSize() {
    $('.page-card iframe').each((index, item) => {
      const $iframe = $(item);
      const parentWidth = $iframe.parent().width();
      const iframeWidth = $iframe.width();

      $iframe.css({
        transform: `scale(${parentWidth / iframeWidth})`,
      });
    });
  }

  /**
   * Parse list pages
   */
  getListPages() {
    const mainPages = ALL_PAGES.filter(e => !DEV_PAGES.includes(e));
    const devPages = ALL_PAGES.filter(e => e !== 'sitemap' && !mainPages.includes(e));

    mainPages.sort((page1, page2) => {
      const indexPage1 = RELEASED_PAGES.indexOf(page1);
      const indexPage2 = RELEASED_PAGES.indexOf(page2);
      if (indexPage1 === -1) {
        return 1;
      } else if (indexPage2 === -1) {
        return -1;
      }
      return indexPage1 - indexPage2;
    });

    devPages.sort((a, b) => a - b);

    this.mainPages = mainPages;
    this.devPages = devPages;
  }
}

export default SitemapController;
