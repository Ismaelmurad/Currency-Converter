<?php

use App\Services\Http\Request;
use App\Services\Routing\Router;

define('ROOT_DIR', dirname(__DIR__));

const APP_DIR = ROOT_DIR . '/app';
const VIEW_DIR = APP_DIR . '/Views';

require(ROOT_DIR . '/vendor/autoload.php');
require(APP_DIR . '/bootstrap.php');

try {
    Router::load(APP_DIR . '/routes.php')
        ->direct(Request::uri(), Request::method());
} catch (Exception $e) {
}