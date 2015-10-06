<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\App;
use SoChat\Chat;
use Flintstone\Flintstone;
use Flintstone\Formatter\JsonFormatter;

require dirname(__DIR__) . '/../vendor/autoload.php';

$dbUsers = Flintstone::load(
    'users',
    [
        'dir' => dirname(__DIR__) . '/../var/db/',
        'formatter' => new JsonFormatter(),
    ]
);

$app = new App('dev.sochat.net', 8080, '0.0.0.0');
$app->route('/', new Chat($dbUsers));
$app->run();






// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat()
//         )
//     ),
//     8080
// );

// $server->run();

