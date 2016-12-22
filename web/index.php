<?php

require '../vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//@ TODO replace haanga to slim container haanga
require dirname(__FILE__)."/../vendor/crodas/haanga/lib/Haanga.php";
$haangaConfig = array(
    'cache_dir' => 'tmp/',
    'template_dir' => 'tpl/',
);
if (is_callable('xcache_isset')) {
    $haangaConfig['check_ttl'] = 300;
    $haangaConfig['check_get'] = 'xcache_get';
    $haangaConfig['check_set'] = 'xcache_set';
}
Haanga::Configure($haangaConfig);

$config = require '../core/config.php';
$app = new \Slim\App(['settings' => $config]);


$GEN_DIR = __DIR__ . '/../gen-php';

/*
 * Containers
 */
$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("pgsql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['model'] = function ($app) {
    $m = new core\ifaces\Model($app);
    return $m;
};

$controllers = glob('../controllers/*.php');
foreach ($controllers as $file) {
    require_once $file;
}

$app->run();