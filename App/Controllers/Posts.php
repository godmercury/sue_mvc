<?php

namespace App\Controllers;

use \Core\View;

/**
 * Post Controller
 */
class Posts extends \Core\Controller
{
    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        echo '<h1>before</h1>';
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        echo '<h1>after</h1>';
    }

    /**
     * Show the index page
     *
     * @return void
     */
    protected function indexAction()
    {
        //echo '<p>Hello from the index action in the Posts controller.</p>';
        //echo '<p>Query string parameter : <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
        View::renderTemplate('Posts/index.html');
    }

    /**
     * Show the add new Page
     *
     * @return void
     */
    protected function addNew()
    {
        echo '<p>Hello from the addNew action in the Posts controller.</p>';
    }

    /**
     * Show the edit Page
     *
     * @return void
     */
    protected function edit()
    {
        echo '<p>Hello from the edit action in the Posts controller.</p>';
        echo '<p>Route parameters : </p>';
        echo '<pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre>';
    }
}
