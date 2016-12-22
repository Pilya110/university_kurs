<?php
/**
 * Services specifications component
 *
 * @package pageBuilder
 * @author I.L.Konev aka Krox
 */

namespace core\components;

/**
 * Class StringHelper
 * @package core\components
 */
class StringHelper
{
    /**
     * Translit string
     * @param string $string
     * @return string
     */
    public static function rus2translit($string)
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }

    /**
     * Replace char for url
     * @param string $str
     * @return mixed|string
     */
    public static function str2url($str)
    {
        $str = self::rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '_', $str);
        $str = trim($str, '_');
        return $str;
    }

    /**
     * Is uuid
     * @param string $guid
     * @return bool
     */
    public static function validateGuid($guid)
    {
        if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $guid)) {
            return true;
        }
        return false;
    }

    /**
     * Generate random string
     * @param integer $len
     * @param string $prefix
     * @return string
     */
    public static function randomString($len, $prefix = '')
    {
        return substr($prefix.md5(time()+rand(1, 10000)), 0 , $len);
    }

    /**
     * Формирует запрос для поиска
     * @param $sQuery
     * @return string
     */
    public static function GetSphinxKeyword($sQuery)
    {
        $aRequestString=preg_split('/[\s,-]+/', $sQuery, 5);
        $aKeyword = [];
        if ($aRequestString) {
            foreach ($aRequestString as $sValue) {
                if (strlen($sValue) > 2) {
                    $aKeyword[] = '(' . $sValue . ' | *' . $sValue . '*)';
                }
            }
            $sSphinxKeyword = implode(' & ', $aKeyword);
        }
        return $sSphinxKeyword;
    }
}