<?php

namespace App\Console\Commands\Advert;

use App\Models\Advert;
use App\Service\Adverts\AdvertsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advert:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set expire status for expired adverts';


    public $service;

    public function __construct (AdvertsService $service) {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $c = 0;
        foreach (Advert::where('expires_at', '<', Carbon::now())->active()->cursor() as $advert) {

            $this->service->expire($advert);
            $c++;
        }

        return $c." Ads were expired";
    }
}
