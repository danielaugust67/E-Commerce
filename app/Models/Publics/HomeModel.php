<?php

namespace App\Models\Publics;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class HomeModel extends Model
{

    public function getCarouselSliders()
    {
        $sliders = DB::table('carousel')
                ->where('locale', '=', app()->getLocale())
                ->orderBy('position', 'asc')
                ->join('slide_link', 'slide_link.for_id', '=', 'carousel.id')
                ->get();
        return $sliders;
    }

}