<?php

namespace Korpus\DataBundle\Model;

use Korpus\DataBundle\Model\FacebookPhoto;
use Korpus\DataBundle\Model\FacebookComment;

class FacebookPhotoAlbum
{
    protected $id;
    protected $count;
    protected $coverPhoto;
    protected $createdTime;
    protected $description;
    protected $from;
    protected $link;
    protected $name;
    protected $photos = array();

    public function __construct($albumUrl)
    {
        $album = json_decode(file_get_contents($albumUrl));

        if (!is_object($album)) {
            throw new \Exception('Provided Album Api Object is not valid JSON');
        } else {
            $this->id = $album->id;
            $this->count = $album->count;
            $this->coverPhoto = $album->cover_photo;
            $this->createdTime = new \DateTime($album->created_time);
            $this->description = $album->description;
            $this->from = $album->from->name;
            $this->link = $album->link;
            $this->name = $album->name;

            $photos = json_decode(file_get_contents($albumUrl . '/photos'));

            foreach ($photos->data as $photo) {
                $p = new FacebookPhoto();
                $p->setCreatedTime(new \DateTime($photo->created_time));
                $p->setFrom($photo->from->name);
                $p->setHeight($photo->height);
                $p->setId($photo->id);
                $p->setLink($photo->link);
                $p->setName($photo->name);
                $p->setPicture($photo->picture);
                $p->setSource($photo->source);
                $p->setWidth($photo->width);
                $p->setImages($photo->images);

                if (isset($photo->comments->data)) {
                    $photoComments = $photo->comments->data;

                    $comments = array();
                    foreach ($photoComments as $comment) {
                        $c = new FacebookComment();

                        $c->setId($comment->id);
                        $c->setCreatedTime(new \DateTime($comment->created_time));
                        $c->setFrom($comment->from->name);
                        $c->setMessage($comment->message);

                        $comments[] = $c;
                    }

                    $p->setComments($comments);
                }

                $this->photos[] = $p;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getCoverPhoto()
    {
        return $this->coverPhoto;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

}