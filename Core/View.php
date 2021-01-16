<?php

namespace Core;

use Exception;
/**
 * View
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view The view file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     * @throws Exception
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // Relative Path to Core directory

        if (is_readable($file)) {
            /** @noinspection PhpIncludeInspection */
            require $file;
        } else {
            throw new Exception("$file not found!");
        }
    }
}
