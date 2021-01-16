<?php

namespace Core;

use Core\Database;
use Core\Helpers;

/**
 * This is Description of Model class
 */
abstract class Model
{
    /** @var Database */
    protected $db;

    /**
     * Create new Model instance.
     */
    public function __construct()
    {
        $this->db = Database::connect()->database;
    }

    /**
     * @param array $data The form data
     *
     * @return array $data The sanitized form data
     */
    protected function sanitizeForm($data): array
    {
        foreach ($data as $key => $val) {
            $key = Helpers::clean($key);
            $val = \is_array($val) ? $this->sanitizeForm($val) : Helpers::clean($val);
            $data[$key] = $val;
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    protected function setFields(array $data = []): Model {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
