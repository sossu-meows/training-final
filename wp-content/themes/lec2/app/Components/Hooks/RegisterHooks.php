<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 21:28
 */

namespace App\Components\Hooks;

use App\Components\ComponentInterface;
use App\Components\Hooks\Admin\AdminActions;
use App\Components\Hooks\Admin\AdminFilters;
use App\Components\Hooks\Ajax\Classes\GetTrainingForSchedule;
use App\Components\Hooks\Ajax\Classes\GetTrainingForShorties;
use App\Components\Hooks\Ajax\Classes\SendContactEmail;
use App\Components\Hooks\Ajax\Classes\sendRequestACall;
use App\Components\Hooks\Ajax\Classes\SendOfferEmail;
use App\Components\Hooks\Ajax\Classes\sendRequestEmail;
use App\Components\Hooks\Ajax\Classes\SendTestEmail;
use App\Components\Hooks\Ajax\Classes\GetPartnerListing;
use App\Components\Hooks\Ajax\Classes\GetNewsFeedListing;
use App\Components\Hooks\Ajax\Classes\GetTrainingListing;
use App\Components\Hooks\Ajax\Classes\AddToCart;
use App\Components\Hooks\Ajax\Classes\GetProducts;
use App\Components\Hooks\Website\Actions;
use App\Components\Hooks\Website\Filters;
use App\Components\Hooks\Website\TemplateHierarchies;

/**
 * All actions + filters have been register here.
 *
 * Class RegisterHooks
 * @package App\Components\Hooks
 */
class RegisterHooks implements ComponentInterface
{

    /**
     * Init all Hooks
     */
    public function init()
    {
        $actions = $this->registerActions();
        $filters = $this->registerFilter();
        $ajaxs   = $this->registerAjax();

        $hooks = array_merge($actions, $filters, $ajaxs);

        if (count($hooks) > 0) {
            foreach ($hooks as $hook) {
                $hook->init();
            }
        }
    }

    /**
     * Register filter
     * @return  array
     */
    public function registerFilter()
    {

        return [
            new Filters(),
            new TemplateHierarchies(),
            new AdminFilters()
        ];
    }

    /**
     * Register actions
     * @return  array
     */
    public function registerActions()
    {
        return [
            new Actions(),
            new AdminActions()
        ];
    }

    /**
     * Register ajax
     * @return  array
     */
    public function registerAjax()
    {
        return [
            new SendContactEmail(),
            new sendRequestACall(),
            new sendRequestEmail(),
            new SendTestEmail(),
            new SendOfferEmail(),
            new GetPartnerListing(),
            new GetNewsFeedListing(),
            new GetTrainingListing(),
            new GetTrainingForShorties(),
            new GetTrainingForSchedule(),
            new AddToCart(),
            new GetProducts(),
        ];
    }
}
