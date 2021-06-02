<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-09
 * Time: 12:01
 */

namespace App\Components\Hooks\Admin\PostTypes\Abstracts;

/**
 * Class AbstractPostTypeProperties - Properties for a post type
 *
 * @package App\Components\Hooks\Admin\PostTypes\Abstracts
 */
abstract class AbstractPostTypeProperties
{

    protected $label;
    protected $name;
    protected $singleName;
    protected $useCategory;
    protected $support;
    protected $currentUser;
    protected $orderBy  = 'ID';
    protected $order    = 'DESC';
    protected $tablePrefix = 'wp_';
    protected $menuIcon = 'dashicons-admin-post';

    /**
     * @return mixed
     */
    public function getSingleName()
    {
        return $this->singleName;
    }

    /**
     * @param mixed $singleName
     */
    public function setSingleName($singleName)
    {
        $this->singleName = $singleName;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param array $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

}