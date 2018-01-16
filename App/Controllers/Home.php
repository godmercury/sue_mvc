<?php

namespace App\Controllers;

use \Core\View;
/**
 * Home Controller
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        //echo '<h1>before</h1>';
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo '<h1>after</h1>';
    }

    /**
    * Show the index page
    *
    * @return void
    */
    protected function indexAction()
    {
        //echo '<p>Hello from the index action in the Home Controller.</p>';
        /*
        View::render('Home/index.php', [
            'name' => 'Dave',
            'colors' => ['red', 'green', 'blue']
        ]);
        */

       View::renderTemplate('Home/index.html', [
          'name' => 'Dave',
          'colors' => ['red', 'green', 'blue']
       ]);
    }
}
