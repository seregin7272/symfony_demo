<?php

namespace App\Controller;

use App\Service\Payment\PaymentInterface;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyTestController extends AbstractController
{
    public function __construct(PaymentInterface $payment)
    {
    }
    /**
     * @Route(
     *     "/my-test/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss|json",
     *         "year": "\d+"
     *     }
     * )
     *
     * /my-test/en/2013/my-latest-post.html
     *
     */
    public function index($_locale, $year, $slug)
    {

       // return $this->redirectToRoute('my-test-number', array('max' => 10));
       // $url = $this->generateUrl('my-test-number', array('max' => 10));

        return $this->json(['username' => 'jane.doe']);
    }

    /**
     * @Route ("/my-test-number", name="my-test-number"))
     * @param MarkdownInterface $markdown
     * @param AdapterInterface $cache
     * @param LoggerInterface $markdownLogger
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function number(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $markdownLogger)
    {
        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;
        $item = $cache->getItem('markdown_'.md5($articleContent));
        if (!$item->isHit()) {
            $item->set($markdown->transform($articleContent));
            $cache->save($item);
        }
        $articleContent = $item->get();


        $markdownLogger->info($articleContent);

       // dd($this->getParameter('admin_email'));

        return $this->render('my_test/number.html.twig', compact('articleContent'));
    }


}
