<?php


namespace App\Controller;


use App\Dto\PostDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ConvertAnnotationController extends AbstractController
{

    /**
     * @Route("/tests/posts/", name="_orders", methods={"GET"})
     * @ParamConverter(name="postDto")
     *
     * @param PostDto $postDto
     * @return JsonResponse
     */
    public function post(PostDto $postDto)
    {

        dd($postDto);
        return $this->json(['ok' => 'ok']);
    }

}