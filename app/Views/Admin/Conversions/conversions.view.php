<?php

use App\Controllers\Controller;
use App\Models\Conversion;
use App\Models\Currency;

Controller::partial(
    'Partials/header',
    [
        'title' => 'conversions',
    ]
);
/**
 * @var Conversion[] $conversions
 * @var Currency[] $currencies
 */
?>

<div class="container">
    <div class="bg-white p-4 shadow mt-4 rounded">
        <h4 class="border-bottom pb-3">Umrechnungen (<?= $total; ?>)</h4>

        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th scope="col">Betrag</th>
                <th scope="col">Basis</th>
                <th scope="col">Ergebnis</th>
                <th scope="col">Ziel</th>
                <th scope="col" class="d-none d-md-table-cell">Datum</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($conversions as $conversion): ?>
                <tr>
                    <td> <?= number_format($conversion->getValue(), 2, ',', '.') ?> </td>
                    <td>
                        <div class="d-none d-md-block">
                            <?= $currencies[$conversion->getBaseCurrencyId()]->getName() ?>
                        </div>
                        <div class="d-md-none">
                            <?= $currencies[$conversion->getBaseCurrencyId()]->getIso4217() ?>
                        </div>
                    </td>
                    <td> <?= number_format($conversion->getResult(), 2, ',', '.') ?> </td>
                    <td>
                        <div class="d-none d-md-block">
                            <?= $currencies[$conversion->getTargetCurrencyId()]->getName() ?>
                        </div>
                        <div class="d-md-none">
                            <?= $currencies[$conversion->getTargetCurrencyId()]->getIso4217() ?>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <div class="d-none d-md-block">
                            <?= $conversion?->getCreatedAt()->format('d.m.Y H:i') ?>
                        </div>
                        <div class="d-md-none">
                            <?= $conversion?->getCreatedAt()->format('d.m.Y') ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="border-top pt-3">
        <?php
        Controller::partial(
            'Partials/pagination',
            [
                'totalPages' => $totalPages,
                'page' => $page,
                'old' => $old,
            ]
        ); ?>
        </div>
    </div>
</div>

<?php
Controller::partial('Partials/footer'); ?>
