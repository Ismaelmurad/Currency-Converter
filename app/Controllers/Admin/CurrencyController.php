<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Enums\Role;
use App\Models\Currency;
use App\Services\FreeCurrencyAPI\ApiClient;
use App\Services\Http\Request;
use App\Services\Http\Response;
use App\Services\Http\ResponseInterface;
use Exception;

class CurrencyController extends Controller
{
    public function index(): Response
    {
        return $this->view(
            'Admin/Currencies/index',
            [
                'currencies' => Currency::query()->get(),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function toggleStatus(): ResponseInterface
    {
        $this->guard(Role::ADMIN);
        $currencyId = Request::input('currency_id');

        if (null === $currencyId) {
            return $this->redirect('/currencies');
        }

        $currency = Currency::find($currencyId);

        if (null === $currency) {
            return $this->redirect('/currencies');
        }

        $currency
            ->setIsActive(!$currency->isActive())
            ->save();

        return $this->redirect('/currencies');
    }

    /**
     * @throws Exception
     */
    public function updateCurrencies(): void
    {
        $this->guard(Role::ADMIN);

        // Get latest currencies from API
        $client = new ApiClient();
        $currencies = $client->getCurrencies();

        // Add / update currencies
        foreach ($currencies['data'] as $result) {
            $currency = Currency::findBy('iso_4217', $result['code']);

            if (null === $currency) {
                $currency = new Currency();
            }

            $currency
                ->setName($result['name'])
                ->setIso4217($result['code'])
                ->setSymbol($result['symbol'])
                ->save();
        }

        // Check for removed currencies
        $knownCurrencies = Currency::query()->keyBy('iso_4217')->get();

        /** @var Currency $knownCurrency */
        foreach ($knownCurrencies as $knownCurrency) {
            if (false === array_key_exists($knownCurrency->getIso4217(), $currencies)) {
                // @ToDo: Soft delete required, before we can do this (no hurry)
                // $knownCurrency->delete();
            }
        }
    }
}
