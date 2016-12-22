<?php
/**
 * Created by PhpStorm.
 * User: rve
 * Date: 13.10.16
 * Time: 14:28
 */

namespace core\ifaces;


class Base
{
    /**
     * @var slim
     */
    protected $app;

    /**
     * Base constructor.
     * @param slim $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Список элементов
     * @return array
     */
    public function getList()
    {
        $list = $this->select($this->table);
        if (!is_array($list)) {
            return [];
        }
        return $list;
    }

    /**
     * Поиск элементов по идентификатору
     * @param string $id
     * @return mixed|null
     */
    public function findById($id)
    {
        if (!isset($this->table)) {
            return null;
        }
        $elements = $this->select($this->table, [['id', '=', $id]]);
        if (!is_array($elements) || 0 === count($elements)) {
            return null;
        }
        return $elements[0];
    }

    /**
     * Добавление записи
     * @param array $data
     * @return array|bool
     */
    public function create($data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Удаление записи
     * @param string $id
     * @return bool
     */
    public function remove($id)
    {
        return $this->delete($this->table, [['id', '=', $id]]);
    }

    /**
     * Обновление модели
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function save($id, $data)
    {
        $page = $this->findById($id);
        if ($page) {
            return $this->update($this->table, $data, [['id', '=', $id]]);
        }
        return false;
    }

    /**
     * Update
     * @param array $data
     * @param array $where
     * @return bool
     */
    protected function update($table, $data, $where)
    {
        $qD = $this->collectQueryUpdate($table, $data, $where);
        if (false === $qD) {
            return false;
        }
        $ds = $this->app->db->prepare($qD['query']);
        if (!$ds->execute($qD['execData'])) {
            return false;
        }
        return true;
    }

    /**
     * Collect query update
     * @param string $table
     * @param array $data
     * @param array $where
     * @return array|bool
     */
    private function collectQueryUpdate($table, $data, $where)
    {
        if (0 === count($data) || 0 === count($where)) {
            return false;
        }
        $query = 'UPDATE ' . $table . ' SET ';
        $execData = [];
        $f = false;
        foreach ($data as $k => $v) {
            if ($f) {
                $query .= ',';
            }
            $insk = ':' . $k;
            $query .= $k . '=' . $insk;
            $f = true;
            $execData[$insk] = $v;
        }
        $query .= ' WHERE ';
        $f = false;
        foreach ($where as $val) {
            $k = $val[0];
            $op = $val[1];
            $v = $val[2];
            if ($f) {
                $query .= ' AND ';
            }
            $insk = ':' . $k;
            $query .= $k . ' ' . $op . ' ' . $insk;
            $f = true;
            $execData[$insk] = $v;
        }
        return [
            'query' => $query,
            'execData' => $execData
        ];
    }

    /**
     * Insert
     * @param string $table
     * @param array $data
     * @param string $return
     * @return array|bool
     */
    protected function insert($table, $data, $return = 'id')
    {
        $qD = $this->collectQueryInsert($table, $data, $return);
        if (false === $qD) {
            return false;
        }
        $ds = $this->app->db->prepare($qD['query']);
        if (!$ds->execute($qD['execData'])) {
            return false;
        }
        return $ds->fetchAll()[0][$return];
    }

    /**
     * Collect query insert
     * @param string $table
     * @param array $data
     * @param string $return
     * @return array|bool
     */
    private function collectQueryInsert($table, $data, $return)
    {
        if (0 === count($data)) {
            return false;
        }
        $query = 'INSERT INTO ' . $table . '(';
        $dF = [];
        $dV = [];
        $execData = [];
        foreach ($data as $k => $v) {
            $insk = ':' . $k;
            $dF[] = $k;
            $dV[] = $insk;
            $execData[$insk] = $v;
        }
        $query .= implode(',', $dF) . ') VALUES (' . implode(',', $dV) . ') RETURNING ' . $return;
        return [
            'query' => $query,
            'execData' => $execData
        ];
    }

    /**
     * Delete
     * @param string $table
     * @param array $where
     * @return bool
     */
    protected function delete($table, $where)
    {
        $qD = $this->collectQueryDelete($table, $where);
        if (false === $qD) {
            return false;
        }
        $ds = $this->app->db->prepare($qD['query']);
        if (!$ds->execute($qD['execData'])) {
            return false;
        }
        return true;
    }

    /**
     * Collect query delete
     * @param string $table
     * @param array $where
     * @return array|bool
     */
    private function collectQueryDelete($table, $where)
    {
        if (0 === count($where)) {
            return false;
        }
        $query = 'DELETE FROM ' . $table;
        $execData = [];
        $query .= ' WHERE ';
        $f = false;
        foreach ($where as $val) {
            $k = $val[0];
            $op = $val[1];
            $v = $val[2];
            if ($f) {
                $query .= ' AND ';
            }
            $insk = ':' . $k;
            $query .= $k . ' ' . $op . ' ' . $insk;
            $f = true;
            $execData[$insk] = $v;
        }
        return [
            'query' => $query,
            'execData' => $execData
        ];
    }

    /**
     * Select
     * @param string $table
     * @param array $where
     * @param array $fields
     * @param array $order
     * @return array|bool
     */
    protected function select($table, $where = [], $fields = ['*'], $order = [])
    {
        $qD = $this->collectQuerySelect($table, $where, $fields, $order);
        if (false === $qD) {
            return false;
        }
        $ds = $this->app->db->prepare($qD['query']);
        if (!$ds->execute($qD['execData'])) {
            return false;
        }
        return $ds->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Collect query select
     * @param string $table
     * @param array $where
     * @param string $fields
     * @param array $order
     * @return array|bool
     */
    private function collectQuerySelect($table, $where, $fields, $order)
    {
        if (0 === count($fields)) {
            return false;
        }
        $query = 'SELECT ' . implode(',', $fields) . ' FROM ' . $table;
        $execData = [];
        if (0 < count($where)) {
            $query .= ' WHERE ';
            $f = false;
            foreach ($where as $val) {
                $k = $val[0];
                $op = $val[1];
                $v = $val[2];
                if ($f) {
                    $query .= ' AND ';
                }
                $insk = ':' . $k;
                $query .= $k . ' ' . $op . ' ' . $insk;
                $f = true;
                $execData[$insk] = $v;
            }
        }
        if (0 < count($order)) {
            $query .= ' ORDER BY ' . implode(',', $order);
        }
        return [
            'query' => $query,
            'execData' => $execData
        ];
    }
}