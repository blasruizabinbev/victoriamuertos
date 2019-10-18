<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

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
            ->add('offerName')
            ->add('firstName')
            ->add('lastName')
            ->add('acceptCommercial')
            ->add('modStatus', 'choice', [
                'editable' => true,
                'choices' => [
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'denied' => 'Denied'
                ]
            ])
            ->add('image', null, [
                'template' => 'admin/CRUD/list_image.html.twig'
            ])
            ->add('createdAt')
        ;

    }

    public function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('uuid')
            ->add('email')
            ->add('fistName')
            ->add('lastName')
            ->add('offerName')
            ->add('dateOfBirth')
            ->add('questionOneAnswer', null, ['label' => 'Question 1'])
            ->add('questionTwoAnswer', null, ['label' => 'Question 2'])
            ->add('questionThreeAnswer', null, ['label' => 'Question 3'])
            ->add('acceptTerms')
            ->add('acceptCommercial')
            ->add('image', null, [
                'template' => 'admin/CRUD/show_image.html.twig'
            ])
            ->add('modStatus', null, [
                'editable' => true
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

}
