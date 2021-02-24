<?php

namespace App\Traits;
trait Location
{
    protected function getLocationLongAlt()
    {
        if ($this->isGust()) {
//            dd(request()->get('location'));
            if (request()->has('location') and request()->get('location') != '') {

                return $this->getExplodeLocation(request()->get('location'),request()->get('city_name'));
            }
        } else {
            if ($this->hasAddresses()) {
                $current = auth('sanctum')->user()->addresses->where('is_current', true)->first();
                if (!$current)
                    return $this->getExplodeLocation(request()->get('location'),request()->get('city_name'));


                return $this->getExplodeLocation($current->location,$current->title);
            }else{
                return $this->getExplodeLocation(request()->get('location'),request()->get('city_name'));
            }
        }
        return ['longitude' => '', 'latitude' => ''];
    }

    protected function isGust()
    {
        return auth('sanctum')->user()->id == 10101010;
    }

    protected function hasAddresses()
    {
        return auth('sanctum')->user()->addresses->count() > 0;
    }
    protected function getExplodeLocation($location,$city_name)
    {
        $long = explode(',', $location)[0];
        $lat = explode(',', $location)[1];
        $city_name = trim(explode('-',$city_name ?? '')[0] ?? '');

        return ['longitude' => $long, 'latitude' => $lat, 'city_name' => $city_name];
    }

}
