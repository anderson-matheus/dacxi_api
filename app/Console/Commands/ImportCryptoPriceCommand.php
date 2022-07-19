<?php

namespace App\Console\Commands;

use App\Services\CoinService;
use Illuminate\Console\Command;

class ImportCryptoPriceCommand extends Command
{
    private CoinService $coinService;

    protected $signature = 'import:crypto-prices';

    protected $description = 'import latest crypto prices';

    public function __construct(CoinService $coinService)
    {
        parent::__construct();
        $this->coinService = $coinService ?? new CoinService();
    }

    public function handle()
    {
        $this->coinService->storeCoinsPrice();
        return 0;
    }
}
