<?php

namespace Core;

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
}
