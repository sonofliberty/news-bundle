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

namespace SonOfLiberty\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use SonOfLiberty\NewsBundle\Entity\PostInterface;

/**
 * Class Post
 * @package SonOfLiberty\NewsBundle\Repository
 */
class Post extends EntityRepository
{
    /**
     * @param string $slug
     * @param bool|null $public
     * @return PostInterface
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findBySlug(string $slug, ?bool $public = true)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug);

        if ($public) {
            $query
                ->andWhere('p.published = 1')
                ->andWhere('p.publicFrom IS NULL or p.publicFrom <= :now')
                ->andWhere('p.publicUntil IS NULL or p.publicUntil >= :now')
                ->setParameter('now', new \DateTime());
        }

        return $query
            ->setMaxResults(1)
            ->setCacheable(true)
            ->getQuery()
            ->getSingleResult();
    }
}
