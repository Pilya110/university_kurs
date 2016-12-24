<?php
/**
 * Created by PhpStorm.
 * User: bulldog
 * Date: 28.10.16
 * Time: 23:04
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*
 * Get List
 */
$app->get('/files', function (Request $request, Response $response) {
    $content = $this->model->file->getList();
    $response->getBody()->write(json_encode($content, true));
    return $response;
});

/*
 * Render file
 */
$app->get('/file', function (Request $request, Response $response) {
    $id = $request->getParam('id');
    $content = $this->model->file->render($id);
    $response->getBody()->write($content);
    return $response;
});

/*
 * Загрузка файлов
 */
$app->post('/upload_file', function (Request $request, Response $response) {
    $res = false;
    if (isset($_FILES['file'])) {
        $oiler = 0;
        if (isset($_POST['oiler'])) {
            $oiler = $_POST['oiler'];
        }
        $file = $_FILES['file'];
        $indx = strripos($file['name'], '.') + 1;
        $type = substr($file['name'], $indx);
        $name = substr($file['name'], 0, $indx-1);
        $res = $this->model->file->create([
            'name' => $name,
            'type' => $type,
            'oiler_id' => $oiler
        ]);
        if ($res) {
            try {
                $this->model->file->putFile($file['tmp_name'], $res, $type);
            } catch (Exception $e) {
                $this->model->file->remove($res);
                throw $e;
            }
        }
    }
    $response->getBody()->write(json_encode($res, true));
});

/*
 *
 */
$app->get('/search', function (Request $request, Response $response) {
    $search = $request->getParam('search');
    if ($search) {
        $s = new SphinxClient;
        $s->setServer('127.0.0.1', 3212);
        $s->setMatchMode(SPH_MATCH_ANY);
        $s->setSortMode(SPH_RANK_SPH04);
        $result = $s->query(\core\components\StringHelper::GetSphinxKeyword($search));
        $ids = [];
        if (isset($result['matches'])) {
            $ids = array_keys($result['matches']);
        }
    } else {
        $params = $request->getParams();
        $oilIds = $this->model->oiler->findByParams($params);
        $ids = $this->model->file->findByOils($oilIds);
    }
    $response->getBody()->write(json_encode($ids, true));
    return $response;
});

/*
 * Delete file
 */
$app->delete('/file', function (Request $request, Response $response) {
    $id = $request->getParam('id');
    $content = $this->model->file->remove($id);
    $response->getBody()->write(json_encode($content, true));
    return $response;
});