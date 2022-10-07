<?php

namespace App\Service;

use App\Entity\Post;

/**
 * interface PostExporterInterface
 *
 * @package App\Service\PostExporter
 *
 * @author Vitali Romanenko <romanenko.vit.kharkiv@gmail.com
 */

interface PostExporterInterface
{
    /**
     * @param Post $post
     * @return void
     */
    public function setPost (Post $post);

    /**
     * @return string
     */
    public function getFileExtention ();

    /**
     * @return string
     */
    public function export ();

}
