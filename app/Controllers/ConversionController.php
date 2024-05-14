<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\Role;
use App\Models\Conversion;
use App\Models\Currency;
use App\Services\Container\App;
use App\Services\FreeCurrencyAPI\ApiClient;
use App\Services\Http\Request;
use App\Services\Http\Response;
use App\Services\Http\ResponseInterface;
use Exception;

class ConversionController extends Controller
{
    public function index(): Response
    {
        if (!App::environment('local')) {
            $this->guard(Role::USER);
        }

        $baseCurrency = Currency::query()->where('iso_4217', '=', 'EUR')->get()[0]->getId();
        $targetCurrency = Currency::query()->where('iso_4217', '=', 'USD')->get()[0]->getId();

        return $this->view(
            'Conversion/index',
            [
                'currencies' => Currency::query()->get(),
                'old' => [
                    'base_currency' => $baseCurrency,
                    'target_currency' => $targetCurrency,
                    'value' => 1,
                ]
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function calculate(): ResponseInterface
    {
        if (!App::environment('local')) {
            $this->guard(Role::USER);
        }

        // Validate base currency

        $baseCurrencyId = Request::input('base_currency');
        $baseCurrency = null;

        if (null !== $baseCurrencyId) {
            $baseCurrency = Currency::find((int)$baseCurrencyId);
        }

        // Validate  target currency

        $targetCurrencyId = Request::input('target_currency');
        $targetCurrency = null;

        if (null !== $targetCurrencyId) {
            $targetCurrency = Currency::find((int)$targetCurrencyId);
        }

        // Validate the value
        $errors = [];

        if (null === $baseCurrency || null === $targetCurrency) {
            $errors += ['base_currency' => 'Ungültige Währung.'];
            $errors += ['target_currency' => 'Ungültige Währung.'];
        }

        $value = Request::input('value');

        if (preg_match('/[^\d.,]/', $value)) {
            $errors += ['value' => 'Ungültiger Wert'];
        }

        if (str_contains($value, ',')) {
            $value = (float)str_replace(',', '.', $value);
        }

        // Validate that base and target currency CANNOT be the same
        if ($baseCurrencyId === $targetCurrencyId) {
            $errors += [
                'target_currency' => 'Die angegebenen Währungen müssen sich von einander unterscheiden.'
            ];
        }

        if (false === empty($errors)) {
            return $this->view(
                'Conversion/index',
                [
                    'errors' => $errors,
                    'currencies' => Currency::query()->keyBy('id')->get(),
                    'old' => Request::input(),
                ]
            );
        }

        $apiClient = new ApiClient();
        $exchangeRate = $apiClient->getLatestExchangeRate($baseCurrency, $targetCurrency);
        $result = $value * $exchangeRate;

        $conversion = (new Conversion())
            ->setBaseCurrencyId($baseCurrency->getId())
            ->setTargetCurrencyId($targetCurrency->getId())
            ->setExchangeRate($exchangeRate)
            ->setValue((float)$value)
            ->setResult($result)
            ->setUserAgent($_SERVER['HTTP_USER_AGENT'] ?? null)
            ->setIpAddress($_SERVER['REMOTE_ADDR'] ?? null);

        if (null !== $this->getUser()) {
            $conversion->setUserId($this->getUser()->getId());
        }

        $conversion->save();

        return $this->view(
            'Conversion/index',
            [
                'conversion' => $conversion,
                'currencies' => Currency::query()->keyBy('id')->get(),
                'result' => $result,
                'old' => Request::input(),
            ]
        );
    }
}
