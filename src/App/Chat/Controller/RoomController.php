<?php

namespace SoChat\App\Chat\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class RoomController
{
    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render(
            'login.html.twig'
        );
    }

    public function roomAction(Request $request, Application $app)
    {
    }

    public function createAction(Request $request, Application $app)
    {
    }

    public function joinAction(Request $request, Application $app)
    {
        if (empty($request->request->get('uname'))) {
            ddd('No uname');
        }

        return $app['twig']->render(
            'room.html.twig',
            [
                'uname' => $request->request->get('uname'),
                'users' => $app['user.helper.getUserListForRoom']->getList(),
            ]
        );
    }

    public function quitAction(Request $request, Application $app)
    {
    }

    public function ajaxGetUserListAction(Request $request, Application $app)
    {
        return $app['twig']->render(
            'partial/userlist.html.twig',
            [
                'users' => $app['user.helper.getUserListForRoom']->getList(),
            ]
        );
    }
    /**
     * @todo we need to be able to obtain an empty port number
     * @todo we need to be able to pass port number to the server init script
     * @param  Request     $request [description]
     * @param  Application $app     [description]
     * @return [type]               [description]
     */
    public function createOneToOne(Request $request, Application $app)
    {
        $port = ''
        $pid = exec('nohup php src/shell/chat-server.php -p '.$port.' & echo $!');
    }
}
