<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Document;
use App\Models\District;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
use App\Models\FacilityType;
use App\Observers\DocumentObserver;
use App\Observers\DistrictObserver;
use App\Observers\HUDObserver;
use App\Observers\BlockObserver;
use App\Observers\PHCObserver;
use App\Observers\HSCObserver;
use App\Observers\FacilityTypeObserver;



class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Document::observe(DocumentObserver::class);
        District::observe(DistrictObserver::class);
        HUD::observe(HUDObserver::class);
        Block::observe(BlockObserver::class);
        PHC::observe(PHCObserver::class);
        HSC::observe(HSCObserver::class);
        FacilityType::observe(FacilityTypeObserver::class);
    }
}
