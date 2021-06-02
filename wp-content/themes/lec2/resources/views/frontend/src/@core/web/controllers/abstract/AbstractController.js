import ViewScope from './ViewScope';

class AbstractController {
  /*
  Declare async plugin used in this controller
   */
  asyncPlugins = [];

  init() {
    const loadPlugins = Promise.all(
      this.asyncPlugins.map(e => global.loadAsyncPlugin(e)),
    );

    // Init view scope
    this.viewScope = ViewScope.getInstance();
    this.viewScope.setViewMethods(this);
    this.viewScope.setViewData(this.viewData());
    this.$scope = this.viewScope.data;
    global.$scope = this.$scope;

    // Before DOM ready
    this.beforeMain();

    $(document).ready(async () => {
      this.main();
      if (this.asyncPlugins.length) {
        await loadPlugins;
      }
    });
  }

  /**
   * After init event before DOM ready
   */
  beforeMain() {

  }

  /**
   * Call to trigger reload view data
   */
  viewReload() {
    this.viewScope.setViewData(this.viewData());
  }

  /**
   * Get inital view data, will be injected to $scope
   */
  viewData() {
    return {};
  }

  /** Component main, should be implemented by sub class */
  main() {
    throw new Error(`Please implement main() (${this.constructor.displayName})`);
  }
}

export default AbstractController;
