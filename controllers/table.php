<?php
/**
 * Created by PhpStorm.
 * User: bulldog
 * Date: 24.12.16
 * Time: 0:51
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/*
 * Получение списков таблиц
 */
$app->get('/table', function (Request $request, Response $response) {
    $table = $request->getParam('table');
    $content = [];
    if ('files' === $table) {
        $content = $this->model->file->getList();
    } else if ('oiler' === $table) {
        $content = $this->model->oiler->getList();
    }
    $response->getBody()->write(json_encode($content, true));
    return $response;
});