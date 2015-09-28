<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\App;
use SoChat\Chat;

require dirname(__DIR__) . '/../vendor/autoload.php';

$app = new App('dev.sochat.net', 8080, '0.0.0.0');
$app->route('/', new Chat());
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
//s($app);
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

