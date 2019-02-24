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

namespace SonOfLiberty\NewsBundle\Entity;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Post
 * @package SonOfLiberty\NewsBundle\Model
 *
 * @Vich\Uploadable()
 */
class Post extends BaseModel implements Translatable, TranslatableInterface, PostInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $image;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="son_of_liberty_news", fileNameProperty="image")
     */
    private $imageFile;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var bool
     */
    private $published = true;

    /**
     * @var \DateTime|null
     */
    private $publicFrom;

    /**
     * @var \DateTime|null
     */
    private $publicUntil;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var AuthorInterface
     */
    private $author;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Post
     */
    public function setSlug(string $slug): Post
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Post
     */
    public function setImage(string $image): Post
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return Post
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile): Post
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Post
     */
    public function setContent(string $content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return Post
     */
    public function setLocale($locale): Post
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Post
     */
    public function setPublished(bool $published): Post
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublicFrom(): ?\DateTime
    {
        return $this->publicFrom;
    }

    /**
     * @param \DateTime|null $publicFrom
     * @return Post
     */
    public function setPublicFrom(?\DateTime $publicFrom): Post
    {
        $this->publicFrom = $publicFrom;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPublicUntil(): ?\DateTime
    {
        return $this->publicUntil;
    }

    /**
     * @param \DateTime|null $publicUntil
     * @return Post
     */
    public function setPublicUntil(?\DateTime $publicUntil): Post
    {
        $this->publicUntil = $publicUntil;
        return $this;
    }

    /**
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt(\DateTime $createdAt): Post
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt(\DateTime $updatedAt): Post
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return AuthorInterface
     */
    public function getAuthor(): ?AuthorInterface
    {
        return $this->author;
    }

    /**
     * @param AuthorInterface $author
     * @return Post
     */
    public function setAuthor(AuthorInterface $author): Post
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @throws \Exception
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return null !== $this->slug ? $this->slug : "";
    }
}
