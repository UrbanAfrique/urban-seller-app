<?php

namespace App\Console\Commands;

use App\Enum\RoleEnum;
use App\Models\Seller;
use App\Services\WebhookService;
use Illuminate\Console\Command;

class syncWebhooks extends Command
{
    protected $signature = 'sync:webhooks';
    protected $description = 'This command is used for syncing Webhooks';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
       $sellers = Seller::all();
       if (count($sellers)>0){
           foreach ($sellers as $seller){
               WebhookService::manage(
                   $seller->token,
                   $seller->domain,
                   RoleEnum::SELLER,
                   $seller->id);
           }
       }
    }
}
