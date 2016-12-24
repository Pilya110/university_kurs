<?php

/**
 * Created by PhpStorm.
 * User: bulldog
 * Date: 28.10.16
 * Time: 23:02
 */

namespace core\models;

use core\ifaces\Base;

class Oiler extends Base
{
    public $table = 'oiler';

    public function findByParams($data)
    {
        $where = [];
        foreach ($data as $k => $v) {
            $where[] = [$k, '=', $v];
        }
        $res = $this->select($this->table, $where);
        $data = [];
        foreach ($res as $v) {
            $data[] = $v['id'];
        }
        return $data;
    }
}