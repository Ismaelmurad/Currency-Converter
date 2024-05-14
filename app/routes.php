<?php

declare(strict_types=1);

/**
 * @var Router $router
 */

use App\Controllers\Admin\AuthenticationController;
use App\Controllers\Admin\ConversionController as AdminConversionController;
use App\Controllers\Admin\CurrencyController;
use App\Controllers\Admin\UserController;
use App\Controllers\ConversionController;
use App\Controllers\PagesController;
use App\Services\Routing\Router;

$router->get('404', [PagesController::class, 'notFound']);

# Converter
$router->get('', [ConversionController::class, 'index']);
$router->get('calculate', [ConversionController::class, 'calculate']);

# Authentication
$router->get('registration', [AuthenticationController::class, 'registrationForm']);
$router->post('registration/store', [AuthenticationController::class, 'registrationStore']);
$router->get('login', [AuthenticationController::class, 'login']);
$router->get('logout', [AuthenticationController::class, 'logout']);
$router->post('authentication', [AuthenticationController::class, 'verifyCredentials']);

# Users
$router->get('users', [UserController::class, 'index']);
$router->get('users/details', [UserController::class, 'details']);
$router->get('users/edit', [UserController::class, 'edit']);
$router->get('users/delete', [UserController::class, 'delete']);
$router->post('users/update', [UserController::class, 'update']);

# Admin
$router->get('conversions', [AdminConversionController::class, 'index']);
$router->get('currencies', [CurrencyController::class, 'index']);
$router->get('currencies/toggle-status', [CurrencyController::class, 'toggleStatus']);
$router->get('update-currencies', [CurrencyController::class, 'updateCurrencies']);
