<?php

return [
    'MINT_ACCESS_KEY' => env('MINT_ACCESS_KEY', 'BHY97uvn'),
    'MINT_SECRET_KEY' => env('MINT_SECRET_KEY', '37672a788526366b2bbe8bf7d9276864'),
    'MINT_USERNAME'   => env('MINT_USERNAME', 'glizer.single'),

    'urls' => [
        'get_current_balance' => 'https://mconnect2.mintroute.com/vendor/api/get_current_balance',
        'brand' => 'https://mconnect2.mintroute.com/vendor/api/brand',

        //        'user_order_create'     => env('YUQUE_API_BASE_URL', 'http://tkog.qr67.com:8080/api') . env('YUQUE_USER_ORDER_CREATE', '/user-order/create'),
        //        'user_order_details'    => env('YUQUE_API_BASE_URL', 'http://tkog.qr67.com:8080/api') . env('YUQUE_USER_ORDER_DETAILS', '/user-order/details'),
        //        'user_products_list'    => env('YUQUE_API_BASE_URL', 'http://tkog.qr67.com:8080/api') . env('YUQUE_USER_PRODUCTS_LIST', '/user-goods/list'),
        //        'user_product_details'  => env('YUQUE_API_BASE_URL', 'http://tkog.qr67.com:8080/api') . env('YUQUE_USER_PRODUCT_DETAILS', '/user-goods/details'),
        //        'merchant_account_info' => env('YUQUE_API_BASE_URL', 'http://tkog.qr67.com:8080/api') . env('YUQUE_MERCHANT_ACCOUNT_INFO', '/user-account'),
    ],
];
