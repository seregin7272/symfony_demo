<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FortunesController extends AbstractController
{
    /**
     * @Route("/fortunes", name="fortune")
     */
    public function index(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
      /*  $filters = $em->getFilters()
            ->enable('fortune_cookie_discontinued');

        $filters->setParameter('discontinued', false);*/

        $categoryRepository = $em->getRepository('App:Category');

        $search = $request->query->get('q');

        if ($search) {
            $categories = $categoryRepository->search($search);
        } else {
            $categories = $categoryRepository->findAllOrdered();
        }

        return $this->render('fortune/homepage.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/fortunes/category/{id}", name="fortune_category_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCategoryAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Category');

        $category = $categoryRepository->findWithFortunesJoin($id);


        $fortunesData = $this->getDoctrine()
            ->getRepository('App:FortuneCookie')
            ->countNumberPrintedForCategory($category);

        $fortunesPrinted = $fortunesData['fortunesPrinted'];
        $averagePrinted = $fortunesData['fortunesAverage'];
        $categoryName = $fortunesData['name'];

        if (!$category) {
            throw $this->createNotFoundException();
        }
        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunesPrinted' => $fortunesPrinted,
            'averagePrinted' => $averagePrinted,
            'categoryName' => $categoryName
        ]);
    }

}
