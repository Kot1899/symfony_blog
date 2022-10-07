<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    protected function getLastId()
    {
        $postRepository = static::getContainer()->get(PostRepository::class);
        $post = $postRepository->findOneBy([], ['id' => 'desc']);

        return $post->getId();
    }

    public function testSomething(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');

        $postLink = $crawler->selectLink('+ Post');
        $this->assertCount(1, $postLink);
    }

    public function testPostEntity()
    {
        $post = new Post();

        $name = 'Alex';
        $post->setName($name);
        $this->assertTrue($post->getName() == $name);

        $desc = 'Test description';
        $post->setDescription($desc);
        $this->assertTrue($post->getDescription() == $desc);
    }

    public function testPostGenerate(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create');
        $this->assertResponseIsSuccessful();

        $s = $client->getResponse()->getContent(); // 'OK!'
        $this->assertTrue($s == 'OK!');
    }

    public function testPostCreate(): void
    {
        $client = static::createClient();
        $previousLastId = $this->getLastId();

        $crawler = $client->request('GET', '/post/create');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form();
        $form['post_form[name]'] = 'Post from phpUnit';
        $form['post_form[description]'] = 'large herbivore';
        $client->submit($form);

        $currentLastId = $this->getLastId();

        $this->assertTrue($currentLastId > $previousLastId);
        $this->assertResponseRedirects('/post/show/' . $currentLastId);
    }

    public function testPostDelete(): void
    {
        $client = static::createClient();
        $client->request('GET', '/post/delete/' . $this->getLastId());

        $this->assertResponseRedirects('/');
    }
}
