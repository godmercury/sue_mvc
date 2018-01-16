<?php

namespace App\Controllers\Admin;

/**
 * Admin Users Controller
 */
class Users extends \Core\Controller
{
    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Show index page
     *
     * @return void
     */
    protected function indexAction()
    {
        echo 'Admin User index';
    }
}
