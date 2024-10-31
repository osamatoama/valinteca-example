<?php

return [
    'secret_id'   => env('YUQUE_SECRET_ID', '8109736719eea105284'),
    'secret_key'  => env('YUQUE_SECRET_KEY', 'Aeqdc4hghUCbYI3AAeqjVMizq2FvV6kE'),
    'urls'        => [
        'user_order_verify'     => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_USER_ORDER_VERIFY', '/user-order-verify/recharge-info'),
        'user_order_create'     => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_USER_ORDER_CREATE', '/user-order/create'),
        'user_order_details'    => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_USER_ORDER_DETAILS', '/user-order/details'),
        'user_products_list'    => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_USER_PRODUCTS_LIST', '/user-goods/list'),
        'user_product_details'  => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_USER_PRODUCT_DETAILS', '/user-goods/details'),
        'merchant_account_info' => env('YUQUE_API_BASE_URL', 'https://api.playsentral.com') . env('YUQUE_MERCHANT_ACCOUNT_INFO', '/api/user-account'),
    ],
];
