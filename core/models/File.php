<?php

/**
 * Created by PhpStorm.
 * User: bulldog
 * Date: 28.10.16
 * Time: 23:02
 */

namespace core\models;

use core\ifaces\Base;

class File extends Base
{
    public $table = 'files';

    /**
     * @var array поддерживаемые форматы файлов
     */
    public $accessType = [
        'jpg',
        'pdf',
        'las'
    ];

    /**
     * Сохраняет файл в файловое хранилище
     * @param string $file
     * @param string $name
     * @param string $type
     * @throws \Exception'
     */
    public function putFile($file, $name, $type)
    {
        $path = __DIR__ . '/../../web/assets/files/' . date('Y-m-d') . '/' . $name;
        $originPath = $path . '/origin/';
        $imgPath = $path . '/img/';
        if (false === mkdir($path, 0777, true)) {
            throw new \Exception('Не удалось создать основную папку');
        }
        mkdir($originPath, 0777);
        mkdir($imgPath, 0777);
        if (false === copy($file, $originPath . 'org')) {
            throw new \Exception('Не удалось сохранить файл' . $file . '   ' . $originPath);
        }
        switch (strtolower($type)) {
            case 'pdf':
                $this->transformPdf($file, $imgPath, $name);
                break;
            case 'jpg':
                $this->transformJpg($file, $imgPath);
                break;
            case 'las':
                $this->transformLas($file, $imgPath, $name);
                break;
        }
    }

    /**
     * Преобразование pdf в png
     * @param $file
     * @param $imgPath
     * @param $id
     */
    public function transformPdf($file, $imgPath, $id)
    {
        exec('convert -density 300 -trim ' . $file . ' -quality 100 ' . $imgPath . 'imgpdf.png &');
        $text = $imgPath . '../text';
        exec('pdftotext ' . $file . ' ' . $text);
        $this->save($id, ['text' => file_get_contents($text)]);
    }

    /**
     * Преобразование pdf в png
     * @param $file
     * @param $imgPath
     * @param $id
     */
    public function transformLas($file, $imgPath, $id)
    {
        copy($file, $imgPath . 'text.txt');
        $this->save($id, ['text' => file_get_contents($file)]);
    }

    /**
     * Преобразование jpg в png
     * @param $file
     * @param $imgPath
     */
    public function transformJpg($file, $imgPath)
    {
        exec('convert ' . $file . ' ' . $imgPath . 'imgpdf.png &');
    }

    /**
     * Формирование html формы для отображения файла
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function render($id)
    {
        $file = $this->findById($id);
        if (is_null($file)) {
            throw new \Exception('Не удалось найти файл');
        }
        $date = date('Y-m-d', strtotime($file['date_create']));
        $imgPath = __DIR__ . '/../../web/assets/files/' . $date . '/' . $id . '/img/';
        $files = [];
        if (is_dir($imgPath)) {
            $files = glob($imgPath . '*.png');
        }
        if (0 === count($files)) {
            $files = glob($imgPath . '*.txt');
            if (0 !== count($files)) {
                $fl = $files[0];
                $flPath = substr($fl, strpos($fl, '/assets/'));
                return '<iframe src="' . $flPath . '"  width="100%" height="550px"></iframe>';
            }
            return 'Файл обрабатывается';
        }
        $content = '';
        foreach ($files as $fl) {
            $flPath = substr($fl, strpos($fl, '/assets/'));
            $content .= '<img src="' . $flPath . '">';
        }
        return $content;
    }

    public function findByOils($ids)
    {
        $res = $this->app->db->query('SELECT * FROM files WHERE oiler_id IN ('.implode(',', $ids).')');
        $ar = $res->fetchAll(\PDO::FETCH_ASSOC);
        $ids = [];
        foreach ($ar as $v) {
            $ids[] = $v['id'];
        }
        return $ids;
    }
}