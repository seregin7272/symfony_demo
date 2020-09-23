<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class TestRabbitMQController extends AbstractController
{

    /**
     * @Route ("/rabbit/first-test")
     */
    public function firstTest()
    {


        // Сообщение .
        // Второе ...
        // Третье ..
        // Первое ....
        // Первое .....




        return $this->json(['ok'=> 'ok']);
    }

}