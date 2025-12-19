<?php

return [
    'coins' => [
        ['title' => 'Cash', 'table' => 'MEMB_INFO', 'column_account' => 'memb___id', 'column_coin' => 'cash'],
        ['title' => 'Gold', 'table' => 'MEMB_INFO', 'column_account' => 'memb___id', 'column_coin' => 'gold'],
    ],
    'vip' => [
        'name'     => ['Free', 'Bronze', 'Silver', 'Gold'],
        'column'   => 'vip',
        'register' => [
            'active' => true,
            'type'   => 1,
            'days'   => 5,
        ],
    ],
    'donate' => [
        'mercadopago' => [
            'is_active' => true,
            'token'     => '',
        ],
        'stripe' => [
            'is_active'     => true,
            'token_stripe'  => '',
            'secret_stripe' => '',
        ],
        'table'             => 'MEMB_INFO',
        'column_account'    => 'memb___id',
        'column_coin'       => 'cash',
        'active_multiplier' => true,
        'multiplier'        => [
            ['min' => 5, 'max' => 20, 'multiplier' => 1],
            ['min' => 21, 'max' => 50, 'multiplier' => 2],
            ['min' => 51, 'max' => 100, 'multiplier' => 3],
            ['min' => 101, 'max' => 200, 'multiplier' => 4],
        ],
    ],
];
