<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 * 
 * PHP Version 7.4
 */
class Escaping extends \Core\Controller {

    protected function before() {
        // echo "(before) ";
        // return false;
    }

    protected function after() {
        // echo " (after)";
    }

    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() {
        //echo "Hello from the index action in the home controller";
        View::render('Escaping/escaping.php');
    }
}