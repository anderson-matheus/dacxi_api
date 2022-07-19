<?php

namespace App\Console\Commands;

use App\Repositories\CoinRepository;
use App\Services\CoinService;
use Illuminate\Console\Command;

class ImportBitcoinPriceCommand extends Command
{
    private CoinService $coinService;
    private CoinRepository $coinRepository;

    protected $signature = 'import:bitcoin-price';

    protected $description = 'import latest bitcoin price';

    public function __construct(CoinService $coinService, CoinRepository $coinRepository)
    {
        parent::__construct();
        $this->coinService = $coinService ?? new CoinService();
        $this->coinRepository = $coinRepository ?? new CoinRepository();
    }

    public function handle()
    {
        $symbol = 'btc';
        $this->coinRepository->activeBySymbol($symbol);
        $this->coinService->storeCoinsPrice(['symbols' => [$symbol]]);
        return 0;
    }
}
