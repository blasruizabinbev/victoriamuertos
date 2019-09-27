<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ProfileAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
        $collection->remove('create');
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('uuid')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('dateOfBirth')
            ->add('questionOneAnswer')
            ->add('questionTwoAnswer')
            ->add('questionThreeAnswer')
            ->add('createdAt')
        ;

    }

}
