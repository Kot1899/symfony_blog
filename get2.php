<?php

/**
 * @Route("/get2/{id}", name="default_get")
 * @param ManagerRegistry $doctrine
 * @return response
 * @author Vitali Romanenko
 * description - its method #2 fetching POST from DB (something SELECT)
 */
public function Get2( int $id, PostRepository $postRepository): Response
{
    $post_get2 = $postRepository->find($id);
    return new Response('well done, it is ok, u post - ' . $post_get2->getName());
}