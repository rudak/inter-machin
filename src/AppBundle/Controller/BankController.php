<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BankController extends Controller
{

    public function indexAction()
    {
        return $this->render(':default:bank.html.twig', []);
    }
}
