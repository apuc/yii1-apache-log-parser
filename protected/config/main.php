<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

//Yii::setPathOfAlias('bootstrap', dirname(__DIR__).'/extensions/bootstrap');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Log Parser',

    // preloading 'log' component
    'preload' => array(
        'log',
        //'bootstrap'
    ),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    //'theme'=>'bootstrap',

    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            //'generatorPaths'=>array('bootstrap.gii',),
        ),
        'logs',
        'user'
    ),

    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'file' => array(
            'class' => 'application.extensions.file.CFile',
        ),
//        'bootstrap'=>array(
//            'class'=>'ext.bootstrap.components.Bootstrap',
//        ),

        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                // REST patterns
                array('api/ip', 'pattern' => 'api/<model:\w+>/<ip:\d+>', 'verb' => 'GET'),
                array('api/date', 'pattern' => 'api/<model:\w+>/<date:\d+>', 'verb' => 'GET'),
                array('api/date-interval', 'pattern' => 'api/<model:\w+>/<date1:\d+>&<date2:\d+>', 'verb' => 'GET'),
            ),
        ),

        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'logPath' => '/var/log/apache2/',
        'accessMask' => 'access.log{,.[0-9]}',
        'errorMask' => 'error.log{,.[0-9]}',
    ),
);
