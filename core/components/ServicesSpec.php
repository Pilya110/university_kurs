<?php
/**
 * Services specifications component
 *
 * @package pageBuilder
 * @author I.L.Konev aka Krox
 */

namespace core\components;

use rigel\client\MCC;

class ServicesSpec
{

    /**
     * Gets all services specifications
     *
     * @return array
     */
    public static function getAll()
    {
        $d = new MCC;
        $data = $d->allSpec();
        return $data;
    }
}
