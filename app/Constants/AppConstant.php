<?php

namespace App\Constants;

class AppConstant
{
    /**
     * Get all available payment gateways.
     */
    public static function getGateways(): array
    {
        return [
            'nagad' => [
                'key' => 'nagad',
                'name' => 'Nagad',
                'description' => 'Nagad is a mobile financial service in Bangladesh operating under the authority of Bangladesh Bank.',
                'url' => asset('assets/gateways/nagad.png'),
            ],
            'bkash' => [
                'key' => 'bkash',
                'name' => 'bKash',
                'description' => 'bKash is a mobile financial service in Bangladesh operating under the authority of Bangladesh Bank.',
                'url' => asset('assets/gateways/bkash.png'),
            ],
        ];
    }
}