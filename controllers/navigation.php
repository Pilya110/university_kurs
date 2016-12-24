<?php
/**
 * Created by PhpStorm.
 * User: rve
 * Date: 25.08.16
 * Time: 11:21
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
/*
 * Общая страница
 */
$app->get('/main', function (Request $request, Response $response) {
    $content = Haanga::load('main.dtl', [], true);
    $response->getBody()->write($content);
    return $response;
});

/*
 * Redirect
 */
$app->get('/', function (Request $request, Response $response) use ($app) {
    return $response->withStatus(302)->withHeader('Location', '/tables');
});

/*
 * Количество зарегестрированных пользователей
 */
$app->get('/countregusers', function (Request $request, Response $response) {
    $content = Haanga::load('countregusers.dtl', [], true);
    $response->getBody()->write($content);
    return $response;
});

/*
 * Количество пользователей онлайн
 */
$app->get('/onlineusers', function (Request $request, Response $response) {
    $content = Haanga::load('onlineusers.dtl', [], true);
    $response->getBody()->write($content);
    return $response;
});

/*
 * Edit tables
 */
$app->get('/tables', function (Request $request, Response $response) {
    $content = Haanga::load('tables.dtl', [], true);
    $response->getBody()->write($content);
    return $response;
});