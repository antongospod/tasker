<?php

namespace App\config;

/**
 * Application configuration
 */
class Config
{
    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'tasker';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Tasks prer page
     * @var int
     */
    const PER_PAGE = 3;

    /**
     * Auth salt
     * @var string
     */
    const AUTH_SALT = 'security-salt-string';

    /**
     * Admin Account ID
     * @var int
     */
    const ADMIN_ID = 1;
}
