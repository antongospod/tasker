<?php

namespace Core;

use App\config\Config;
use function is_array;

/**
 * Class Helpers
 * @package Core
 */
class Helpers
{

    /**
     * @param $data
     * @param string $type
     * @return array|int|string
     */
    public static function clean($data, $type = 'str')
    {
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[self::clean($key)] = self::clean($val);
            }
            $result = $data;
        } else {
            switch ($type) {
                case 'int':
                    $result = (int)$data;
                    break;
                case 'str':
                default:
                    $result = htmlspecialchars(stripslashes(trim(strip_tags($data))));
                    break;
            }
        }

        return $result;
    }


    /**
     * @param string $path
     * @return string
     */
    public static function asset($path = ''): string
    {
        return rtrim(Config::BASE, '/') . '/' . rtrim(Config::BASE_ASSET_PATH, '/') . '/' . rtrim($path, '/');
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return string
     */
    public static function path(
        string $path = '',
        array $params = []
    ): string
    {
        $queryString = self::buildQueryString($params);
        $queryString = $queryString ? '&' . $queryString : '';

        return rtrim(Config::BASE, '/') . '/' . rtrim($path, '/') . $queryString;
    }

    /**
     * @return array $parseUri
     *
     */
    public static function parseURI(): array
    {
        $parseUri = [];
        if (isset($_SERVER['REQUEST_URI'])) {
            $parseUri = explode(
                '/',
                filter_var(
                    rtrim(self::clean($_SERVER['REQUEST_URI']), '/'),
                    FILTER_SANITIZE_URL
                )
            );
        }

        return $parseUri;
    }

    /**
     * @return string $queryString
     */
    public static function getQueryString(): string
    {
        $queryString = filter_var(
            rtrim($_SERVER['QUERY_STRING'], '/'),
            FILTER_SANITIZE_URL
        );
        $queryString = explode('&', $queryString);

        unset($queryString[0]);

        $queryString = implode('&', $queryString);

        return $queryString;
    }

    /**
     * @return array $parsedData
     */
    public static function parseQueryString(): array
    {
        $parsedData = [];
        $queryString = self::getQueryString();
        $splitData = $queryString ? explode('&', $queryString) : [];

        foreach ($splitData as $pair) {
            [$key, $value] = explode('=', $pair);
            $parsedData[self::clean($key)] = self::clean($value);
        }

        return $parsedData;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function buildQueryString(array $data = []): string
    {
        $string = '';
        foreach ($data as $key => $val) {
            $string .= $key . '=' . $val . '&';
        }

        return rtrim($string, '&');
    }

    /**
     * @param int $totalItems
     * @param int $countItems
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public static function calculatePaginationMeta(
        int $totalItems = 0,
        int $countItems = 0,
        int $page = 1,
        int $limit = Config::PER_PAGE
    ): array
    {
        $totalItems = $totalItems < 0 ? 0 : $totalItems;
        $countItems = $countItems < 0 ? 0 : $countItems;
        $page = $page < 1 ? 1 : $page;
        $limit = $limit < 0 ? Config::PER_PAGE : $limit;

        $total = $totalItems > 0 && $limit > 0
            ? ceil($totalItems / $limit)
            : 0;

        return [
            'previous' => $total > 0 ? $page - 1 : 0,
            'next' => $page >= $total ? 0 : $page + 1,
            'current' => $page,
            'limit' => $limit,
            'total' => $total,
            'countItems' => $countItems,
            'totalItems' => $totalItems,
        ];
    }

    /**
     * @return string $current_uri
     */
    public static function getCurrentURI(): string
    {
        $parsedUri = self::parseURI();

        return $parsedUri ? implode('/', $parsedUri) : '';
    }

    /**
     * @param string $path
     *
     * @return boolean $bool
     */
    public static function isCurrentURI($path = ''): bool
    {
        $currentUri = self::getCurrentURI();
        $strPos = ($path !== '') ? strpos($currentUri, $path, 0) : -1;

        return $strPos === 0 || $path === $currentUri;
    }

    /**
     * @param string $method
     *
     * @return boolean $bool
     */
    public static function isRequestMethod($method = 'POST'): bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($method);
    }

    /**
     * @return boolean $bool
     */
    public static function isAdminAuth(): bool
    {
        return !empty($_SESSION['authUserId']) && $_SESSION['authUserId'] === Config::ADMIN_ID ?: false;
    }

    /**
     * @return boolean $bool
     */
    public static function isAuth(): bool
    {
        return !empty($_SESSION['authUserId']);
    }

    /**
     * @param int $userId
     *
     * @return int
     */
    public static function auth(int $userId): int
    {
        return $_SESSION['authUserId'] = $userId;
    }

    /**
     * @return bool
     */
    public static function logout(): bool
    {
        return self::deleteFlash('authUserId');
    }

    /**
     * @param string $path
     * @param array $params
     *
     * @return void
     */
    public static function redirectTo(
        string $path = '',
        array $params = []
    )
    {
        header('Location: ' . self::path($path, $params));
        exit;
    }

    /**
     * @param mixed $key
     * @param string $value
     *
     * @return mixed
     */
    public static function setFlash($key, $value = '')
    {
        return $key ? $_SESSION[$key] = $value : false;
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public static function getFlash($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public static function deleteFlash($key): bool
    {
        if (!empty($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }

        return true;
    }
}
