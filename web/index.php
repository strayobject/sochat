<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['config.path.base'] = realpath(__DIR__.'/../').'/';

require_once $app['config.path.base'].'src/App/Bootstrap.php';

$app->run();