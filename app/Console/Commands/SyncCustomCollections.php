<?php

namespace App\Console\Commands;

use App\Enum\ShopifyEndPointEnum;
use App\Models\Seller;
use App\Services\CustomCollectionService;
use App\Services\ShopifyService;
use Illuminate\Console\Command;

class SyncCustomCollections extends Command
{
    protected $signature = 'sync:custom-collections';
    protected $description = 'Sync Custom Collections';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sellers = Seller::all();
        if (count($sellers) > 0) {
            foreach ($sellers as $seller) {
                CustomCollectionService::syncAll($seller);
            }
        }
    }
}
