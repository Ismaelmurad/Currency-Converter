<?php

declare(strict_types=1);

use App\Services\Container\App;
use App\Services\Database\Connection;
use App\Services\Database\QueryBuilder;
use App\Services\Session\Session;
use Symfony\Component\Dotenv\Dotenv;

session_start();
require(APP_DIR . '/Helpers/functions.php');

$dotenv = new Dotenv();
$dotenv->load(ROOT_DIR . '/.env');

App::bind(
    'database',
    new QueryBuilder(
        Connection::make([
            'connection' => 'mysql:host=' . $_ENV['DB_HOST'] ?? 'mariadb' . ';charset=utf8mb4',
            'name' => $_ENV['DB_NAME'] ?? 'currency_converter',
            'username' => $_ENV['DB_USER'] ?? 'currency_converter',
            'password' => $_ENV['DB_PASS'] ?? 'secret',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ],
        ])
    )
);

App::bind(
    'session',
    new Session()
);
