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

namespace SonOfLiberty\NewsBundle\Controller;

use Doctrine\ORM\NoResultException;
use SonOfLiberty\NewsBundle\EventListener\Event\PostEvent;
use SonOfLiberty\NewsBundle\Repository\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 * @package SonOfLiberty\NewsBundle\Controller
 */
class PostController extends AbstractController
{
    /**
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPostAction(string $slug)
    {
        /** @var Post $repo */
        $repo = $this->getDoctrine()->getRepository('SonOfLibertyNewsBundle:Post');
        try {
            $post = $repo->findBySlug($slug);
        } catch (NoResultException $exception) {
            throw $this->createNotFoundException();
        }

        $this->container->get('event_dispatcher')->dispatch(PostEvent::PRE_RENDER, new PostEvent($post));

        return $this->render('@SonOfLibertyNews/post_detail.html.twig', ['post' => $post]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function listPostsAction(Request $request)
    {
        /** @var Post $repo */
        $repo = $this->getDoctrine()->getRepository('SonOfLibertyNewsBundle:Post');

        $query = $repo->createQueryBuilder('p')
            ->where('p.published = 1')
            ->andWhere('p.published = 1')
            ->andWhere('p.publicFrom IS NULL or p.publicFrom <= :now')
            ->andWhere('p.publicUntil IS NULL or p.publicUntil >= :now')
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('now', new \DateTime())
            ->setCacheable(true);

        return $this->render('@SonOfLibertyNews/post_list.html.twig', [
            'posts' => $this->container->get('knp_paginator')->paginate($query, $request->query->getInt('page', 1))
        ]);
    }
}
