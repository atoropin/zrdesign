<?php

namespace App\Console\Commands;

use App\Currency;
use Illuminate\Console\Command;
use GuzzleHttp\Client as Client;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currenciesArr = $this->getCurrencies();

        Currency::where('code', 'DOL')->update([
            'exchange_rate' => $currenciesArr["USD"]
        ]);

        Currency::where('code', 'EUR')->update([
            'exchange_rate' => $currenciesArr["EUR"]
        ]);
    }

    public function getCurrencies()
    {
        $res = [];

        /** Getting USD currency */
        $client = new Client();
        $test = $client->get('http://free.currencyconverterapi.com/api/v5/convert?q=USD_RUB&compact=y')->getBody();
        $res['USD'] = (json_decode($test)->USD_RUB->val)*1.03;

        /** Getting EUR currency */
        $client = new Client();
        $test = $client->get('http://free.currencyconverterapi.com/api/v5/convert?q=EUR_RUB&compact=y')->getBody();
        $res['EUR'] = (json_decode($test)->EUR_RUB->val)*1.03;

        return $res;
    }
}
