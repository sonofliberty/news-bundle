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

namespace SonOfLiberty\NewsBundle\Sonata\Seo;

use Sonata\SeoBundle\Seo\SeoPageInterface;
use SonOfLiberty\NewsBundle\EventListener\Event\PostEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SeoSubscriber
 * @package SonOfLiberty\NewsBundle\Sonata\Seo
 */
class SeoSubscriber implements EventSubscriberInterface
{
    /**
     * @var SeoPageInterface|null
     */
    private $seoPage;

    /**
     * SeoSubscriber constructor.
     * @param SeoPageInterface|null $seoPage
     */
    public function __construct(?SeoPageInterface $seoPage)
    {
        $this->seoPage = $seoPage;
    }


    /**
     * @param PostEvent $event
     */
    public function onPreRender(PostEvent $event)
    {
        if (!($this->seoPage instanceof SeoPageInterface)) {
            return;
        }

        $post = $event->getPost();

        $this->seoPage->setTitle($post->getTitle());
        $this->seoPage->addMeta('property', 'og:title', $post->getTitle());
        $this->seoPage->addMeta('name', 'twitter:title', $post->getTitle());

        $this->seoPage->addMeta('name', 'description', $description = $this->truncate($post->getContent(), 320));
        $this->seoPage->addMeta('property', 'og:description', $description);
        $this->seoPage->addMeta('name', 'twitter:description', $description);
    }

    /**
     * @param string $text
     * @param int|null $chars
     * @return bool|string
     */
    private function truncate(string $text, ?int $chars = 25)
    {
        $text = $text." ";
        $text = substr($text, 0, $chars);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text."...";

        return $text;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [PostEvent::PRE_RENDER => 'onPreRender'];
    }
}
