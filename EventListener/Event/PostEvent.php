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

namespace SonOfLiberty\NewsBundle\EventListener\Event;

use SonOfLiberty\NewsBundle\Entity\PostInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewsEvent
 * @package SonOfLiberty\NewsBundle\EventListener\Event
 */
class PostEvent extends Event
{
    const PRE_RENDER = 'son_of_liberty_news.post.pre_render';

    /**
     * @var PostInterface
     */
    private $post;

    /**
     * PostEvent constructor.
     * @param PostInterface $post
     */
    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }

    /**
     * @return PostInterface
     */
    public function getPost(): PostInterface
    {
        return $this->post;
    }
}