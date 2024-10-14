<?php

namespace App\Helpers;

class CommonHelper
{

    // public const SYSTEM_CURRENCY = 'PKR';

    public const PER_PAGE = 10;

    public static $currencies = [
        1 => [
            'id' => 1,
            'name' => 'PKR',
            'symbol' => 'Rs.',
            'code' => 'PKR',
            'sort' => 0
        ],
        2 => [
            'id' => 2,
            'name' => 'SAR',
            'symbol' => 'SR.',
            'code' => 'SAR',
            'sort' => 1
        ],
    ];

    /**
     * Return with success or error from here
     * @author M Nabeel Arshad
     * @param
     * @return
     */
    public static function redirect($type, $msg, $route = '')
    {
        if (!$route) {
            return redirect()->back()->with($type, $msg)->withInput();
        }
        return redirect()->route($route)->with($type, $msg);
    }

    public static $planPriceDurations = [
        1 => [
            'id' => 1,
            'title' => '1 Month',
            'duration' => '+1 month',
            'sort' => 0
        ],
        2 => [
            'id' => 2,
            'title' => '6 Months',
            'duration' => '+6 month',
            'sort' => 1
        ],
        3 => [
            'id' => 3,
            'title' => '1 Year',
            'duration' => '+1 year',
            'sort' => 2
        ],
    ];

    public static $vehicle_types = [
        1 => ['id' => 1, 'name' => 'Bike'],
        2 => ['id' => 2, 'name' => 'Rikshaw'],
        3 => ['id' => 3, 'name' => 'Car']
    ];

    /**
     * Get user type based on the request
     * @author M Nabeel Arshad
     * @return string|null
     */
    public static function getGuardName(): string|null
    {
        return request()->whoIs;
    }
}
