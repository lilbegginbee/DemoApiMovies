<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

return array(
    'site' => array(
        'title' => 'demoApiMovies'
    ),
    'api' => array(
        'hashids_salt' => 'Movies Salt'
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
    ),
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=demoapimovies;host=127.0.0.1',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
