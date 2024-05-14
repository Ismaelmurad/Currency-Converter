<?php
/** @var Currency $currency */

use App\Controllers\Controller;
use App\Models\Conversion;
use App\Models\Currency;

Controller::partial(
    'Partials/header',
    [
        'title' => 'Conversion',
    ]
);

/**
 * @var Conversion $conversion
 * @var Currency[] $currencies
 * @var int $base_currency
 * @var int $target_curency
 * @var string $result
 */
?>
<div class="container">
    <div class="row">
        <div class="col-10 col-md-11 col-lg-9 col-xl-10 col-xxl-6 m-auto" style="width: 1320px">

            <div class="mt-4 bg-white p-5 p-md-4 shadow rounded">
                <form
                        class="row mb-0"
                        method="get"
                        action="/calculate"
                        xmlns="http://www.w3.org/1999/html"
                >
                    <div class="col-12 col-md-3 mb-3 mb-md-0">
                        <label
                                for="value"
                                class="fw-bold mb-2 d-md-none">
                            Betrag:
                        </label>
                        <input type="text"
                               class="form-control shadow-sm mb-md-0 font-monospace <?= !empty($errors['value']) ? 'is-invalid' : '' ?>"
                               placeholder="Betrag"
                               aria-label="Betrag"
                               value="<?= $old['value'] ?? 1 ?>"
                               name="value"
                               id="value"
                        >
                        <?php
                        if (isset($errors['value'])) : ?>
                            <div class="invalid-feedback mb-3">
                                <?= $errors['value'] ?>
                            </div>
                        <?php
                        endif; ?>
                    </div>
                    <div class="col-12 col-md-3 mb-3 mb-md-0">
                        <label
                                for="base_currency"
                                class="fw-bold mb-2 d-md-none">
                            Währung:
                        </label>
                        <select class="form-select shadow-sm bg-body rounded me-2 font-monospace <?= isset($errors['base_currency']) ? 'is-invalid' : '' ?>"
                                name="base_currency"
                                id="base_currency"
                        >
                            <?php
                            foreach ($currencies as $currency): ?>
                                <option
                                        value="<?= $currency->getId() ?>"
                                        <?php
                                        if ((int)$old['base_currency'] === $currency->getId()) : ?>selected<?php
                                endif; ?>
                                >
                                    <?= $currency->getIso4217() . ' &nbsp;(' . $currency->getName() . ')' ?>
                                </option>
                            <?php
                            endforeach; ?>
                        </select>
                        <?php
                        if (isset($errors['base_currency'])) : ?>
                            <div class="invalid-feedback">
                                <?= $errors['base_currency'] ?>
                            </div>
                        <?php
                        endif; ?>
                    </div>

                    <div class="col-12 col-md-1 d-flex justify-content-center align-items-center">
                        <div class="d-none d-md-block">
                            <i class="bi bi-arrow-right fs-4"></i>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mt-md-none">
                        <label
                                for="target_currency"
                                class="fw-bold mb-2 d-md-none">
                            Ziel:
                        </label>
                        <select class="form-select shadow-sm bg-body rounded me-2 font-monospace <?= isset($errors['target_currency']) ? 'is-invalid' : '' ?>"
                                aria-label="default select example"
                                name="target_currency"
                                id="target_currency"
                        >
                            <?php
                            foreach ($currencies as $currency): ?>
                                <option
                                        value="<?= $currency->getId() ?>"
                                        <?php
                                        if ((int)$old['target_currency'] === $currency->getId()) : ?>selected<?php
                                endif; ?>
                                >
                                    <?= $currency->getIso4217() . ' &nbsp;(' . $currency->getName() . ')' ?>
                                </option>
                            <?php
                            endforeach; ?>
                        </select>
                        <?php
                        if (isset($errors['target_currency'])) : ?>
                            <div class="invalid-feedback">
                                <?= $errors['target_currency'] ?>
                            </div>
                        <?php
                        endif; ?>
                    </div>
                    <div class="col-12 col-md-2 mt-md-none">
                        <button
                                type="submit"
                                class="btn btn-success bi bi-calculator-fill w-100 mt-4 mt-md-0"
                        >
                            <span class="d-md-none">Umrechnen</span>
                        </button>
                    </div>
                </form>
            </div>
            <?php
            if (isset($conversion)) : ?>
            <div class="mt-4 bg-white p-5 shadow rounded">

                <div class="card-title text-center fw-bold fs-4">
                    <h2 class="mb-4">
                        <?= $currencies[$conversion->getTargetCurrencyId()]->getName(); ?>
                    </h2>
                    <p class="text-success fs-1">
                        <?= number_format($result, 2, ',', '.'); ?>
                    </p>
                    <div class="text-secondary fs-6">
                        1 <?= $currencies[$conversion->getBaseCurrencyId()]->getIso4217(); ?>
                        = <?= number_format($conversion->getExchangeRate(), 2, ',', '.'); ?>
                        <?= $currencies[$conversion->getTargetCurrencyId()]->getIso4217(); ?>
                    </div>
                    <div class="fs-6 text-secondary text-opacity-50 mt-2"
                    ">
                    Stand <?= $conversion->getCreatedAt()->format('d.m.Y') ?><br>
                </div>
            </div>
        </div><!-- /main -->
        <?php
        endif; ?>
    </div>
</div>
</div>

<script>
    document.querySelector('#value').focus();
</script>
<?php
Controller::partial('Partials/footer'); ?>
