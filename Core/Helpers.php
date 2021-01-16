<?php

namespace Core;

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
        if (\is_array($data)) {
            foreach ($data as $key => $val) {
                $data[self::clean($key)] = self::clean($val);
            }
            $result = $data;
        } else {
            switch ($type) {
                case 'int':
                    $result = (int) $data;
                    break;
                case 'str':
                default:
                    $result = htmlspecialchars(stripslashes(trim(strip_tags($data))));
                    break;
            }
        }

        return $result;
    }
}
