<?php

namespace Core;

/**
 * View
 */
class View
{
    /**
     * Render a view file
     *
     * @param string $view The view file
     *
     * @return viod
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = '../App/Views/' . $view;

        if (is_readable($file)) {
            require_once $file;
        } else {
            // echo $file . ' not found.';
            throw new \Exception($file . ' not found.');
        }
    }

    /**
     * Rendar a view template using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}
