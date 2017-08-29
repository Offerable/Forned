<?php
/**
 * Brightery Facebook Bushiness Scraper v3
 * @Author: Muhammad El-Saeed <m.elsaeed@brightery.com.eg>
 * @link: https://www.brightery.com.eg/en/product/brightery-facebook-business-scraper
 * @copyright: 2016 Brightery Inc.
 *
 */

// SETUP SECURITY
define('Brightery', true);
ini_set('display_errors', 1);

// SETUP A DEVELOPMENT ENVIRONMENT
error_reporting(E_ALL);

// GETTING CONFIGURATIONS AND AUTOLOAD LIBRARIES
function __autoload($class)
{
    $parts = explode('\\', $class);
    $parts = implode('/', array_map(function ($part) {
        return ucfirst($part);
    }, $parts));
    require ucfirst($parts) . '.php';
}

function superInstance($object)
{
    if (isset(Brightery\Configurations::$superInstance[$object]))
        return Brightery\Configurations::$superInstance[$object];
    else {
        $prepare = "Brightery\\$object";
        Brightery\Configurations::$superInstance[$object] = new $prepare();
        return Brightery\Configurations::$superInstance[$object];
    }
}

Brightery\Configurations::$superInstance['config'] = require '../config.php';

// SETUP INPUT METHOD AND FILTER
$input = superInstance('Input');

if ($do = $input->get('do')) {
    if ($do = explode('/', $do))
        $prepare = "Brightery\\$do[0]";
    $obj = new $prepare();
    if (isset($do[1]))
        $obj->{$do[1]}();
}