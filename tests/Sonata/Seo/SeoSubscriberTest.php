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
 * Date: 2019-03-16
 * Time: 15:41
 */

namespace SonOfLiberty\NewsBundle\tests\Sonata\Seo;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\Seo\SeoPage;
use SonOfLiberty\NewsBundle\Entity\Post;
use SonOfLiberty\NewsBundle\EventListener\Event\PostEvent;
use SonOfLiberty\NewsBundle\Sonata\Seo\SeoSubscriber;

class SeoSubscriberTest extends TestCase
{
    public function testOnPreRender()
    {
        $seoPage = new SeoPage();
        $seoSubscriber = new SeoSubscriber($seoPage);
        $post = (new Post())->setTitle('BCH PLS')->setContent('qzw5r82m3eml8mr8cpg3e5wy7x6wcdf7aydgunc6vj');
        $seoSubscriber->onPreRender(new PostEvent($post));
        $pageMetas = $seoPage->getMetas();

        $this->assertStringContainsString($post->getTitle(), $seoPage->getTitle());
        $this->assertArrayHasKey('og:title', $pageMetas['property']);
        $this->assertArrayHasKey('twitter:title', $pageMetas['name']);

        $this->assertArrayHasKey('description', $pageMetas['name']);
        $this->assertArrayHasKey('og:description', $pageMetas['property']);
        $this->assertArrayHasKey('twitter:description', $pageMetas['name']);
    }
}
