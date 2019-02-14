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

/**
 * Created by PhpStorm.
 * User: alexwinter
 * Date: 2019-02-12
 * Time: 15:10
 */

namespace SonOfLiberty\NewsBundle\Doctrine\Subscriber;

use Cocur\Slugify\SlugifyInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use SonOfLiberty\NewsBundle\Entity\Post;

/**
 * Class PostSubscriber
 * @package SonOfLiberty\NewsBundle\Doctrine\Subscriber
 */
class PostSubscriber implements EventSubscriber
{
    /**
     * @var string
     */
    private $authorClass;

    /**
     * @var SlugifyInterface|null
     */
    private $slugify;

    /**
     * PostSubscriber constructor.
     * @param string $authorClass
     * @param SlugifyInterface|null $slugify
     */
    public function __construct(string $authorClass, ?SlugifyInterface $slugify)
    {
        $this->authorClass = $authorClass;
        $this->slugify = $slugify;
    }

    /**
     * @param LoadClassMetadataEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $metadata = $args->getClassMetadata();
        if ($metadata->getName() !== Post::class) {
            return;
        }

        $metadata->mapManyToOne([
            'fieldName' => 'author',
            'targetEntity' => $this->authorClass,
            'joinColumn' => [
                'name' => 'author_id',
                'referencedColumnName' => 'id',
                'nullable' => true
            ]
        ]);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        return;

        /** @var Post|mixed $object */
        $object = $args->getObject();
        if (!($object instanceof Post) || !($this->slugify instanceof SlugifyInterface)) {
            return;
        }

        if (null === $object->getSlug()) {
            $object->setSlug($this->slugify->slugify($object->getTitle()));
        }
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
            Events::prePersist
        ];
    }
}