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
     * Database driver
     * @var string
     */
    const DB_DRIVER = 'mysql';

    /**
     * Database port
     * @var string
     */
    const DB_PORT = '3306';

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

    /**
     * Base application path
     * @var string
     */
    const BASE = '';

    /**
     * Base application assets path
     * @var string
     */
    const BASE_ASSET_PATH = 'assets';
}
