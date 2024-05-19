<?php

$router = $di->getRouter();

// Define your routes here

$router->handle($_SERVER['REQUEST_URI']);
$router->removeExtraSlashes(true);

$router
    ->add('/rate',
        [
            'controller'    => 'usd-api',
            'action'        => 'rate'
        ])
    ->via( [ 'GET' ] );

$router
    ->add('/subscribe',
        [
            'controller'    => 'usd-api',
            'action'        => 'subscribe'
        ])
    ->via( [ 'POST' ] );

$router
    ->add('/send_mails',
        [
            'controller'    => 'mail-api',
            'action'        => 'send'
        ])
    ->via( [ 'GET' ] );

$router
    ->add('/test',
        [
            'controller'    => 'mail-api',
            'action'        => 'test'
        ])
    ->via( [ 'GET' ] );
