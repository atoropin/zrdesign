<?php

namespace App\Console\Commands;

use App\Suppliers;
use Illuminate\Console\Command;

class SetCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:set';

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
        $currenciesList = self::getCurrencies();

        foreach ($currenciesList as $key => $value) {
            $supplier = Suppliers::whereNotNull('type')->findOrFail($key);
            $supplier->currency_id = (int)$value;
            $supplier->save();
        }
    }

    public static function getCurrencies()
    {
        return [
            "8" => "2",
            "11" => "2",
            "17" => "2",
            "19" => "1",
            "22" => "2",
            "39" => "1",
            "40" => "1",
            "41" => "2",
            "43" => "1",
            "44" => "2",
            "46" => "1",
            "47" => "2",
            "48" => "2",
            "49" => "2",
            "51" => "2",
            "53" => "2",
            "55" => null,
            "57" => "1",
            "59" => "2",
            "62" => "2",
            "65" => "2",
            "67" => "2",
            "69" => "1",
            "73" => null,
            "75" => null,
            "78" => null,
            "80" => null,
            "82" => null,
            "84" => null,
            "86" => "2",
            "88" => "2",
            "89" => "1",
            "90" => "1",
            "91" => "1",
            "94" => "1",
            "95" => "2",
            "97" => "2",
            "99" => "2",
            "100" => "2",
            "102" => "1",
            "103" => "2"
        ];
    }
}
