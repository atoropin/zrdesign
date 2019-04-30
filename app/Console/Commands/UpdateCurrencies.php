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
        $delta = 1.01;

        Currency::where('code', 'DOL')->update([
            'exchange_rate' => $currenciesArr["USD"] * $delta
        ]);

        Currency::where('code', 'EUR')->update([
            'exchange_rate' => $currenciesArr["EUR"] * $delta
        ]);

        Currency::where('code', 'GBP')->update([
            'exchange_rate' => $currenciesArr["GBP"] * $delta
        ]);
    }

    public function getCurrencies()
    {
        $currenciesArr = [];

        /** Getting USD currency */
        $client = new Client();
        $USDExchangeCurr = $client->get('https://api.exchangeratesapi.io/latest?base=USD')->getBody();
        $currenciesArr['USD'] = (json_decode($USDExchangeCurr)->rates->RUB);

        /** Getting EUR currency */
        $client = new Client();
        $EURExchangeCurr = $client->get('https://api.exchangeratesapi.io/latest?base=EUR')->getBody();
        $currenciesArr['EUR'] = (json_decode($EURExchangeCurr)->rates->RUB);

        /** Getting EUR currency */
        $client = new Client();
        $GBPExchangeCurr = $client->get('https://api.exchangeratesapi.io/latest?base=GBP')->getBody();
        $currenciesArr['GBP'] = (json_decode($GBPExchangeCurr)->rates->RUB);

        return $currenciesArr;
    }
}
