<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    public function indexAction()
    {
        return $this->render(':admin:index.html.twig',[]);
    }

    public function graphsAction()
    {
        return $this->render(':admin:graphs.html.twig',[]);
    }
}
