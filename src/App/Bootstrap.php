<?php

use Flintstone\Flintstone;
use Flintstone\Formatter\JsonFormatter;

$app['debug'] = true;

$app['db.users'] = $app->share(function () {
    return Flintstone::load(
        'users',
        [
            'dir' => dirname(__DIR__).'/../var/db/',
            'formatter' => new JsonFormatter(),
        ]
    );
});

$app['user.helper.getUserListForRoom'] = function () use ($app) {
    return new SoChat\App\User\Helper\UserListForRoom($app['db.users']);
};

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['config.path.base'].'/src/App/View',
));

$app->get('/', 'SoChat\\App\\Chat\\Controller\RoomController::indexAction')
    ->bind('home')
;
$app->post('/', 'SoChat\\App\\Chat\\Controller\RoomController::joinAction');
/*
 * for future use
 */
$app->post('/room', 'SoChat\\App\\Chat\\Controller\RoomController::createAction');
$app->delete('/room', 'SoChat\\App\\Chat\\Controller\RoomController::deleteAction');
$app->post('/room/{id}/join', 'SoChat\\App\\Chat\\Controller\RoomController::joinAction');

$app->get('/ajax/userlist', 'SoChat\\App\\Chat\\Controller\RoomController::ajaxGetUserListAction');
