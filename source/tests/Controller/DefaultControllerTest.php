<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex(): void
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a ', 'Logo');

        // check link +Post
        $postLink=$crawler->selectLink('+Post');
        $this->assertCount(1, $postLink);

        // check link About
        $aboutLink=$crawler->selectLink('About');
        $this->assertCount(1, $aboutLink);

        // check link Feedback
        $feedbackLink=$crawler->selectLink('Feedback');
        $this->assertCount(1, $feedbackLink);

        // check link Instagram
        $instagramLink=$crawler->selectLink('Instagram');
        $this->assertCount(1, $instagramLink);

        // check link Facebook
        $facebookLink=$crawler->selectLink('Facebook');
        $this->assertCount(2, $facebookLink);

    }
//    public function testKOt(): void
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/');
//
//        $postLink=$crawler->selectLink('+Post');
//        $this->assertCount(1, $postLink);
//    }
//
    public function testAbout() :void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');

        $this->assertResponseIsSuccessful();
    }

    public function testKile() :void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/author/kile');

        $this->assertResponseIsSuccessful();
    }

    public function testFeedback() :void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/feedback');

        $this->assertResponseIsSuccessful();
    }

    public function testAuthor() :void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/create_author');

        $this->assertResponseIsSuccessful();
    }

}
