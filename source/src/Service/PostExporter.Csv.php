<?php

namespace App\Service;
use App\Entity\Post;

/**
 * Class PostExporterCsv
 *
 * @author Vitali Romanenko <romanenko.vit.kharkiv@gmail.com>
 * @package App\Service\ExpotretCsv
 */

class PostExporterCsv implements PostExporterInterface
{
     /**
      * var Post
      */
     protected $post;

     /**
      * @param Post $post
      * @return void
      */
     public function setPost(Post $post)
     {
         $this->post= $post;
     }

    /**
     * @return string|void
     */
    public function getFileExtention ()
    {
        return 'csv';
    }

    /**
     * @return string|void
     */
    public function export ()
    {
        return $this->post->getName() . ';' . $this->post->getDescription(). ';' . $this->post->getPublicAt();

    }

}