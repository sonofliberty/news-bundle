<?php
/**
 * Copyright (c) 2019 Aleksander Winter <aleksander.winter.89@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */

namespace SonOfLiberty\NewsBundle\Sonata\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use SonOfLiberty\NewsBundle\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\VichUploaderBundle;

/**
 * Class PostAdmin
 * @package SonOfLiberty\NewsBundle\Sonata\Admin
 */
class PostAdmin extends AbstractAdmin
{
    /**
     * @var array
     */
    private $bundles = [];

    /**
     * @var string|null
     */
    private $authorClass;

    /**
     * PostAdmin constructor.
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param array $bundles
     * @param string|null $authorClass
     */
    public function __construct(string $code, string $class, string $baseControllerName, array $bundles, ?string $authorClass)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->bundles = $bundles;
        $this->authorClass = $authorClass;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
        if ($this->authorClass && class_exists($this->authorClass)) {
            $list->add('author');
        }
        $list->add('createdAt');
        $list->add('published', null, ['editable' => true]);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('General', ['class' => 'col-md-8', 'box_class' => 'box box-solid']);
        $form->add('title', TextType::class);
        $form->add('slug', TextType::class, ['required' => false]);
        if (in_array(VichUploaderBundle::class, $this->bundles)) {
            $form->add('imageFile', VichImageType::class, ['required' => false]);
        }
        $form->add('content', TextareaType::class, ['attr' => ['class' => 'tinymce', 'data-theme' => 'advanced', 'rows' => 15]]);
        $form->end();

        $form->with('Details', ['class' => 'col-md-4']);
        if ($this->authorClass && class_exists($this->authorClass)) {
            $form->add('author');
        }
        $form->add('published');
        $form->add('publicFrom');
        $form->add('publicUntil');
        $form->end();
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'create', 'edit']);
    }
}
