<?php

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $app['config.path.base'].'/src/App/View'
));