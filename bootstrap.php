<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 10:14 AM
 */
require_once 'vendor/autoload.php';

$app = new \Silex\Application();

$app['debug'] = true;

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/src/templates',
));

$app->register(new Silex\Provider\SessionServiceProvider());