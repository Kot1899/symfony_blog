<?php

namespace App\Service;
use App\Entity\Post;

/**
 * Class PostExporterHtml
 *
 * @author Vitali Romanenko <romanenko.vit.kharkiv@gmail.com>
 * @package App\Service\ExpotretCsv
 */

class PostExporterHtml implements PostExporterInterface
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
        return 'html';
    }

    /**
     * @return string|void
     */
    public function export ()
    {
        $export='';
        $export .= '<strong>' . $this->post->getName() . '</strong>'. '<br/>';
        $export .= '<p>' . $this->post->getDescription() . '</p>'. '<br/>';
        $export .= '<p>' . $this->post->getPublicAt() . '</p>'. '<br/>';

        return $export;
    }

}