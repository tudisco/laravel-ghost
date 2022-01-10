<?php

namespace Igorsgm\Ghost\Models;

class Author
{
    /**
     * @var string|null
     */
    public $id;

    /**
     * @var string|null
     */
    public $slug;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $profileImage;

    /**
     * @var string|null
     */
    public $coverImage;

    /**
     * @var string|null
     */
    public $bio;

    /**
     * @var string|null
     */
    public $website;

    /**
     * @var string|null
     */
    public $location;

    /**
     * @var string|null
     */
    public $facebook;

    /**
     * @var string|null
     */
    public $twitter;

    /**
     * @var string|null
     */
    public $metaTitle;

    /**
     * @var string|null
     */
    public $metaDescription;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var integer
     */
    public $postsCount;

    /**
     * @param  array  $array
     * @return Author
     */
    public static function createFromArray($array): Author
    {
        $author = new self();

        $author->slug = $array['slug'] ?? null;
        $author->id = $array['id'] ?? null;
        $author->name = $array['name'] ?? null;
        $author->profileImage = $array['profile_image'] ?? null;
        $author->coverImage = $array['cover_image'] ?? null;
        $author->bio = $array['bio'] ?? null;
        $author->website = $array['website'] ?? null;
        $author->location = $array['location'] ?? null;
        $author->facebook = $array['facebook'] ?? null;
        $author->twitter = $array['twitter'] ?? null;

        $author->seo = Seo::createFromArray($array);

        $author->postsCount = data_get($array, 'count.posts');

        return $author;
    }

    public function getResourceName()
    {
        return 'authors';
    }
}
