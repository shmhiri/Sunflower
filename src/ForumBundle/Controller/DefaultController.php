<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Forum/Default/index.html.twig');
    }

    public function indexfAction()
    {
        return $this->render('@Forum/Default/indexf.html.twig');
    }

    public function bloglistshowAction()
    {
        return $this->render('@Forum/Commentaire/bloglist.html.twig');
    }

    public function blogdetailshowAction()
    {
        return $this->render('@Forum/Commentaire/blogdetail.html.twig');
    }

}
