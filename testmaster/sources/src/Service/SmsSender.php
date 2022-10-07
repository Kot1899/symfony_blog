<?php

namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class SmsSender
 *
 * @author Yandex <ab@piogroup.net>
 * @package App\Service
 */
class SmsSender
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $port;

    /**
     * SmsSender constructor.
     *
     * @param string                $host
     * @param string                $port
     * @param UrlGeneratorInterface $router
     */
    public function __construct($host, $port, UrlGeneratorInterface $router)
    {
        $this->router = $router;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Connect to sms provider
     *
     * @return void
     */
    public function connect()
    {
        //... some logic
    }

    /**
     * General send message method
     *
     * @example $smsSender->send(['101', '102', '103'], 'Hello!');
     * @example $smsSender->send('101', 'Hello!');
     *
     * @param string|array $to
     * @param string       $msg
     *
     * @return void
     */
    public function send($to, $msg)
    {
        //...
    }

    /**
     * Send main hello message
     *
     * @param string|array $to
     *
     * @return void
     */
    public function sendHello($to)
    {
        $this->send($to, 'Hello');
    }

    /**
     * @param string|array $to
     *
     * @return void
     */
    public function sendNotificationCreate($to)
    {
        $url = $this->router->generate('homepage');
        $this->send($to, 'Notification create post, click here - ' . $url);
    }

    /**
     * @param string|array $to
     *
     * @return void
     */
    public function sendNotificationEdit($to)
    {
        $this->send($to, 'Notification edit post');
    }
}
