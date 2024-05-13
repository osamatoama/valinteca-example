<?php

return [
    'secret_id'   => env('YUQUE_SECRET_ID', '44996512a9fb1faf0'),
    'secret_key'  => env('YUQUE_SECRET_KEY', 'p1VGdbxuYwU3imSlAR6VjqOD40xCJOC6'),
    'urls'        => [
        'user_order_verify'     => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_USER_ORDER_VERIFY', '/user-order-verify/recharge-info'),
        'user_order_create'     => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_USER_ORDER_CREATE', '/user-order/create'),
        'user_order_details'    => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_USER_ORDER_DETAILS', '/user-order/details'),
        'user_products_list'    => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_USER_PRODUCTS_LIST', '/user-goods/list'),
        'user_product_details'  => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_USER_PRODUCT_DETAILS', '/user-goods/details'),
        'merchant_account_info' => env('YUQUE_API_BASE_URL', 'http://tkog.qsios.cn') . env('YUQUE_MERCHANT_ACCOUNT_INFO', 'api/user-account'),
    ],
];
