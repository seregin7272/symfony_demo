<?php


namespace App\Controller;


use App\Service\Test;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestContainerController extends AbstractController
{


    /**
     * @Route("/test")
     * @param Test $test
     * @return Response
     */
    public function test(Test $test)
    {

        //$logger->info('Look! I just used a service');

        return new Response($test->getMessage());
    }
}
