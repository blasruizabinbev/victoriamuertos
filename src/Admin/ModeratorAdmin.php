<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ModeratorAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'moderator';
    protected $baseRouteName = 'moderator';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list']);
        $collection->add('store');
    }
}