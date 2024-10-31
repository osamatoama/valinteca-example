<?php

return [
    'secret_id'  => env('YUQUE_SECRET_ID', '8109736719eea105284'),
    'secret_key' => env('YUQUE_SECRET_KEY', 'Aeqdc4hghUCbYI3AAeqjVMizq2FvV6kE'),
    'urls'       => [
        'user_order_verify'     => 'https://api.playsentral.com/api/user-order-verify/recharge-info',
        'user_order_create'     => 'https://api.playsentral.com/api/user-order/create',
        'user_order_details'    => 'https://api.playsentral.com/api/user-order/details',
        'user_products_list'    => 'https://api.playsentral.com/api/user-goods/list',
        'user_product_details'  => 'https://api.playsentral.com/api/user-goods/details',
        'merchant_account_info' => 'https://api.playsentral.com/api/user-account',
    ],
];
