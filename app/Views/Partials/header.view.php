<?php

use App\Controllers\Controller;

?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php
            if (!empty($title)): ?><?= $title . ' - ' ?><?php
            endif; ?>Currency Converter</title>
        <link rel="icon" href="/images/favicon.ico" type="image/ico">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-secondary">
<?php Controller::partial('Partials/navigation'); ?>