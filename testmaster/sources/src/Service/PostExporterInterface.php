<?php

namespace App\Service;

use App\Entity\Post;

/**
 * Interface PostExporterInterface
 *
 * @package App\Service\PostExporter
 */
interface PostExporterInterface
{
    /**
     * @param Post $post
     * @return void
     */
    public function setPost(Post $post);

    /**
     * @return string
     */
    public function getFileExtension();

    /**
     * @return string
     */
    public function export();
}
