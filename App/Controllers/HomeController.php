<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

/**
 * Home controller
 */
class HomeController extends Controller
{
    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        View::render('index.php');
    }
}
