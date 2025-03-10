<?php

namespace App\Console\Commands;

use App\Enum\ShopifyEndPointEnum;
use App\Models\Seller;
use App\Services\CustomerService;
use App\Services\ShopifyService;
use Illuminate\Console\Command;

class SyncCustomers extends Command
{
    protected $signature = 'sync:customers';
    protected $description = 'Sync Customers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sellers = Seller::all();
        if (count($sellers) > 0) {
            foreach ($sellers as $seller) {
                CustomerService::syncAll($seller);
            }
        }
    }
}
