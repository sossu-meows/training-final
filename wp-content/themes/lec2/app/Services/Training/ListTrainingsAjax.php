<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Training;

use App\Services\AbstractListingAjax;
use App\Services\Helper;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListTrainingsAjax extends AbstractListingAjax
{

    protected  $query = [
        'post_type'         => 'product',
        'orderby'           => 'date',
        'order'             => 'desc',
        'post_status'       => 'publish'
    ];

    public function makeFilter() {

        if ($_GET) {
            $key            = isset($_GET['search']) ? $_GET['search'] : null ;
            $taxonomyID     = isset($_GET['training_cat_id']) ? $_GET['training_cat_id'] : null;
            $trainingTypeID = isset($_GET['training_type_id']) ? $_GET['training_type_id'] : null;
        }
        if ($_POST) {
            $key            = isset($_POST['search']) ? $_POST['search'] : null ;
            $taxonomyID     = isset($_POST['training_cat_id']) ? $_POST['training_cat_id'] : null ;
            $trainingTypeID = isset($_POST['training_type_id']) ? $_POST['training_type_id'] : null;
        }
        
        if (!empty($key)) {
            $this->query['s'] = $key;
        }

        if (!empty($taxonomyID)) {
            $this->query['tax_query'] = array( 
                array( 
                    'taxonomy'  => 'product_cat', //or tag or custom taxonomy
                    'field'     => 'id',
                    'terms'     => $taxonomyID
                ),
            );
        }

        if (!empty($trainingTypeID)) {

            $this->query['meta_query'] = array(
                array(
                    'key'   => 'training_types_&&_training_type',
                    'value' => $trainingTypeID
                )
            );
        }
    }
}