<?php

namespace App\Service;

use App\Entity\Post;

/**
 * Class PostExporterCsv
 *
 * @package App\Service\PostExporter
 * @author Yandex <ab@piogroup.net>
 */
class PostExporterCsv implements PostExporterInterface
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @param Post $post
     * @return void
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return 'csv';
    }

    /**
     * @return string
     */
    public function export()
    {
        return $this->post->getName() . ';' . $this->post->getDescription();
    }
}
