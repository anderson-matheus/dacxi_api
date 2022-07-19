<?php

namespace App\Console\Commands;

use App\Clients\CoinGeckoClient;
use App\Repositories\CoinRepository;
use App\Services\CoinService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportCryptoCommand extends Command
{
    private CoinService $coinService;

    protected $signature = 'import:cryptos';

    protected $description = 'import all cryptos by CoinGecko API';

    public function __construct(CoinService $coinService) 
    {
        parent::__construct();
        $this->coinService = $coinService ?? new CoinService();
    }

    public function handle()
    {
        $this->coinService->upsertAllCoins();
        return 0;
    }
}
