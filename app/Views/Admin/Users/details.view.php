<?php

/** @var User $user */

use App\Controllers\Controller;
use App\Models\User;

Controller::partial(
    'Partials/header',
    [
        'title' => 'details',
    ]
); ?>

    <div class="container">
        <h1 class="page-title text-white pb-3">Benutzer: <?= htmlentities($user->first_name); ?></h1>
        <div class="row">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3 bg-white p-3">
                <p class="fw-bolder">Benutzerdetails:</p>
                <table class="table table-bordered w-100">
                    <tbody>
                    <tr>
                        <th>ID:</th>
                        <td> <?= $user->id; ?> </td>
                    </tr>

                    <tr>
                        <th>Vorname:</th>
                        <td><?= htmlentities($user->first_name); ?> </td>
                    </tr>

                    <tr>
                        <th>Nachname:</th>
                        <td><?= htmlentities($user->last_name); ?> </td>
                    </tr>

                    <tr>
                        <th>E-Mail:</th>
                        <td><?= htmlentities($user->email); ?> </td>
                    </tr>

                    <tr>
                        <th>Erster Besuch:</th>
                        <td><?= formatDate($user->first_visited_at); ?> </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= $user->isActive() ? 'Ja' : 'Nein' ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
Controller::partial('Partials/footer'); ?>