<?php

use App\Controllers\Controller;
use App\Models\Currency;

/** @var Currency[] $currencies */
?>
<?php
Controller::partial(
    'Partials/header',
    [
        'title' => 'currencies',
    ]
);
?>

    <div class="container">
        <div class="bg-white p-4 shadow mt-4 rounded">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">ISO-Code</th>
                    <th scope="col" style="width: 40px">Aktiv?</th>
                    <th scope="col">Erstellt</th>
                    <th scope="col">Aktualisiert</th>
                </tr>
                </thead>
                <tbody>

                <?php
                /** @var Currency $currency */

                foreach ($currencies as $currency): ?>
                    <tr>
                        <?php
                        /** @var Currency $currency */ ?>
                        <td><?= $currency->getId(); ?></td>
                        <td><?= $currency->getName(); ?></td>
                        <td><?= $currency->getIso4217(); ?></td>
                        <td>
                            <a
                                    class="btn btn-sm w-100 <?= true === $currency->isActive(
                                    ) ? 'btn-success' : 'btn-warning'; ?>"
                                    href="/currencies/toggle-status?currency_id=<?= $currency->getId(); ?>"
                            >
                                <?= true === $currency->isActive() ? 'ja' : 'nein'; ?>
                            </a>
                        </td>
                        <td><?= $currency->getCreatedAt() ?></td>
                        <td><?= $currency->getUpdatedAt() ?></td>
                    </tr>
                <?php
                endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
<?php
Controller::partial('Partials/footer'); ?>