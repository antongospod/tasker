<?php

namespace Core;

use Exception;

/**
 * Base controller
 */
abstract class Controller
{
    /**
     * @param string $modelName The name of the Model class
     *
     * @return object Model
     */
    protected function model($modelName)
    {
        $model = 'App\\Models\\' . $modelName;

        return new $model;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * @throws Exception
     * @throws Exception
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], $args);
        } else {
            throw new Exception("Method $method not found in controller " . get_class($this));
        }
    }
}
