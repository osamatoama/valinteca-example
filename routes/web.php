<?php

use App\Exports\AbayaExport;
use App\Exports\DataExport;
use App\Exports\OrdersExport;
use App\Exports\RatingsExport;
use App\Exports\SlimShClients;
use App\Http\Controllers\TapPaymentController;
use App\Jobs\AbayaJob;
use App\Jobs\FirstLevel;
use App\Jobs\QueueJob;
use App\Jobs\SlimShCientsJob;
use App\Jobs\SlimShMenController;
use App\Jobs\SyncAbayaOrdersJob;
use App\Jobs\ZadlyOrders;
use App\Mail\CerMail;
use App\Models\AbayaProducts;
use App\Models\Code;
use App\Models\Email;
use App\Models\Order;
use App\Models\Player;
use App\Models\PricesGroups;
use App\Models\PricesProducts;
use App\Models\Rating;
use App\Services\SallaWebhookService;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use robertogallea\LaravelPython\Services\LaravelPython;

Route::get('/', function () {

    return "<h1>Hello Valinteca</h1>";
});

Route::get('migrate', function () {
    Artisan::call('migrate');

    return Artisan::output();
});

Route::get('seed/{seeder}', function ($seeder) {
    Artisan::call('db:seed', ['--class' => $seeder]);

    return Artisan::output();
});

Route::get('/power-bi', function () {

    return view('power-bi');

});

Route::get('/python/{file}', function ($file) {
    $data = '"971508403823@c.us,new message from sys arguments"';
    $service = new LaravelPython();
    $result = $service->run(base_path('python/glizer.py'));

    dd($result);
    //  php artisan python:run ./python/glizer.py  ""
    //    $parameters = array('par1', 'par2');
    //    $result = $service->run('/path/to/script.py', $parameters);

});


Route::any('detect-theme', function (Request $request) {
    $sallaClassMap = [
        'salla-1298199463' => 'رائد',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        ''                 => '',
        'salla-2046553023' => 'عطاء',
        'salla-246711701'  => 'بوتيك',

        'salla-773200552'  => 'فخامة',
        'salla-5541564'    => 'كليك',
        'salla-213071771'  => 'يافا',
        'salla-73130640'   => 'عالي',
        'salla-349994915'  => 'وسام',
        'salla-1130931637' => 'ملاك',
        'salla-989286562'  => 'فريد',

        'salla-632105401'  => 'سيليا',
        'salla-880152961'  => 'اكاسيا',
        'salla-388819608'  => 'الكترون',
        'salla-1378987453' => 'زاهر',
    ];
    if ($request->isMethod('post')) {
        $sallaThemeClass = '';
        $websiteContent = getWebsiteContent($request->url);
        if (is_array($websiteContent) && ($websiteContent['status'] ?? false) && (((int)$websiteContent['status']) === 200)) {

            foreach (explode("\n", $websiteContent['output']) as $line) {

                if (Str::contains($line, '<body')) {
                    $line = Str::replace(['class=', '"', '<body', '<', '>'], '', $line);


                    foreach (explode(" ", $line) as $class) {
                        if (Str::contains($class, 'salla')) {
                            $sallaThemeClass = $class;
                        }
                    }


                }

            }
        }
        dump($sallaThemeClass);

        return $sallaClassMap[$sallaThemeClass] ?? 'غير معروف';
    }

    return view('detect-theme');


});


Route::get('tap-payment', [TapPaymentController::class, 'pay']);
Route::get('tap-payment-callback', [TapPaymentController::class, 'callback'])->name('payment.callback');


Route::get('abaya-statistics', function () {
    $one_star = Rating::where('stars', 1)->count();
    $two_stars = Rating::where('stars', 2)->count();
    $three_stars = Rating::where('stars', 3)->count();
    $four_stars = Rating::where('stars', 4)->count();
    $five_stars = Rating::where('stars', 5)->count();

    return view('abaya-statistics', compact('one_star', 'two_stars', 'three_stars', 'four_stars', 'five_stars'));
});


Route::get('swiper-js-demo-effect-cards', function () {
    $products = DB::table('salla_products')->take(60)->get();

    return view('swiper-js-demo-effect-cards', compact('products'));
});

Route::get('swiper-js-demo-vertical', function () {
    $products = DB::table('salla_products')->take(60)->get();

    return view('swiper-js-demo-vertical', compact('products'));
});

Route::get('swiper-js-demo-effect-coverflow', function () {
    $products = DB::table('salla_products')->take(60)->get();

    return view('swiper-js-demo-effect-coverflow', compact('products'));
});

Route::get('/price-compare', function () {
    ss();

    $groups = PricesGroups::with('products')->get();

    return view('prices-compare', compact('groups'));
});

Route::get('/public_update', function () {


    $pricesProducts = PricesProducts::all();
    foreach ($pricesProducts as $product) {
        updatePrice($product);

    }

    return redirect()->back();
})->name('public_update');

Route::post('/create-group-prices', function (Request $request) {

    PricesGroups::create($request->all());

    return redirect()->back();


})->name('create-group-prices');

Route::post('/create-price-product', function (Request $request) {

    $priceGroup = PricesGroups::find($request->input('group_id'));
    $product = $priceGroup->products()->create($request->all());
    updatePrice($product);

    return redirect()->back();

})->name('create-price-product');

Route::get('/abaya', function () {
    \Artisan::call('migrate:fresh --seed ');
    $api_key = 'ory_at_YxFO3FVvTXWFNo3jCsnFXdhbGEtDUsxjf6uLe4iEY-4.Bq2tz7jn3I5fEMMuVOmZA6_zWKJyQ-ZAgfVubQg5By8';
    $salla = new SallaWebhookService($api_key);
    $pagination = $salla->getOrdersForAbaya()['pagination'];

    foreach (range(1, $pagination['totalPages']) as $page) {
        dispatch(new SyncAbayaOrdersJob($api_key, $page));
    }


});

Route::get('/abaya-show', function () {

    $products = AbayaProducts::with('options')->get();
    echo "<div style='direction: rtl; margin: 20px'>";
    foreach ($products as $product) {
        if (blank($product->options)) {
            continue;
        }
        echo '<h1 style="text-align: center">' . $product->name . '</h1>';
        echo '<img style="height: 200px; width: 200px; " src="' . $product->thumbnail . '" />';
        $createdOptions = [];

        foreach ($product->options as $option) {
            if ( ! isset($createdOptions[$option['value']])) {
                $createdOptions[$option['value']] = $option['quantity'];
            } else {
                $createdOptions[$option['value']] += $option['quantity'];
            }
        }
        foreach ($createdOptions as $value => $quantity) {
            echo "<p style='font-weight: bold; font-size: 24px'>";
            echo "المقاس:  " . $value . ' | ' . ' الكمية:   ' . $quantity;
            echo "</p>";

        }
        echo '============================================================================================= <br />';
        $createdOptions = [];


    }
    echo "</div>";
});

Route::get('/scrapping', function () {

    $url = 'https://sa.investing.com/commodities/gold-news';
    $httpClient = new \GuzzleHttp\Client();
    $response = $httpClient->get($url);
    $htmlString = (string)$response->getBody();
    preg_match_all("/<article> * <\/article>/im", $htmlString, $output);


});

Route::get('/google-sheet', function (Request $request) {
    // 503924502923-7vqkfjmic1vipt7n9793l0scu59ag72f.apps.googleusercontent.com
    // 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


    $append = [
        //$this->name,
        // $this->message,
        now()->toDateTimeString(),
    ];


    Sheets::spreadsheet('12tMsCqfI6E4n-wbyWmjv8N3FYCk1XJ7U-M2r93BwWHg')->sheet(1)->append([$append]);


});

// 4VK4EDIzCY7U18KGoD5cpU5jqhjMOb-XnbhDbFzZ0Vo.H9fCQGqVm2NwpZFvqlMy1afKXyNYmy_rzCW3itYGT7U
Route::get('/slimsh-export-clients-as-orders', function () {
    $api_key = 'Hje8BpaTFLR1hYf_AG68mRaFnDO5O03FFF7cx6QoXOI.565TOrM57lrwWYiwEJ4FcAf5EpdqblqTmsSRyzrNjjo';
    $salla = new SallaWebhookService($api_key);

    $ordersForPagination = $salla->getOrders()['pagination'];
    foreach (range(1, $ordersForPagination['totalPages']) as $page) {
        dispatch(new SlimShCientsJob($page, $api_key));
    }
});
Route::get('/slimsh-export-clients-as-orders-excel', function () {
    return Excel::download(new SlimShClients(), 'slimsh.xlsx');
});


Route::get('/abaya-clients', function () {
    $api_key = '4VK4EDIzCY7U18KGoD5cpU5jqhjMOb-XnbhDbFzZ0Vo.H9fCQGqVm2NwpZFvqlMy1afKXyNYmy_rzCW3itYGT7U';
    $salla = new SallaWebhookService($api_key);

    $orders = $salla->getOrdersDateRange()['pagination'];
    foreach (range(1, $orders['totalPages']) as $page) {
        dispatch(new AbayaJob($page, $api_key))->delay(now()->addSeconds($page * 3));
    }
});
Route::get('/abaya-clients-export', function () {
    return Excel::download(new AbayaExport(), 'abayas_orders.xlsx');
});


Route::get('/slimsh-clients-export', function () {
    return Excel::download(new DataExport(), 'all_clients.xlsx');
});

Route::get('/slimsh-clients', function () {
    $api_key = 'ory_at_UBITVQ_zzSliY5yxGJKvSOc5cRi9eyHV4q2JIkWBD4E.0LlRusg6O1-68Ni-w08gtAsWQodDswCeWpHILC117vA';
    foreach (range(1, 945) as $page) {
        dispatch(new SlimShMenController($page, $api_key))->onQueue('slimsh')->delay(now()->addSeconds($page * 3));
    }
});

Route::get('/zadly-orders-export', function () {
    return Excel::download(new OrdersExport(), 'all_orders.xlsx');
});

Route::get('/zadly-orders', function () {

    $api_key = 'ob_X82TpmA2gMuWnmqpPpKU-luQ97Vy4XYhynEEorVk.MXAp_vv1AnU6_rRZ4LVy4bKL7zcNu7fWTD6lXlMyAgM';

    $salla = new SallaWebhookService($api_key);
    $orders = $salla->getOrders();
    foreach (range(1, $orders['pagination']['totalPages']) as $page) {
        ZadlyOrders::dispatch($page, $api_key)->delay(now()->addSeconds($page * 3));
    }

});


Route::get('/export-ratings', function (Request $request) {
    return Excel::download(new RatingsExport, 'all_numbers.xlsx');
});


Route::get('/mailchimp', function () {

    try {
        $mailchimp = new MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => 'b87d45635228a3ada699b15fd7a8c74a-us17',
            'server' => 'us17',
        ]);

        $email = 'altoama@outlook.com';
        $name = 'Osama Toama';
        $explodeName = explode(' ', $name);
        $first_name = $explodeName[0];
        $last_name = ' ';
        if (isset($explodeName[1])) {
            unset($explodeName[0]);
            $last_name = implode(' ', $explodeName);
        }

        $data = [
            'status'        => 'subscribed',
            'email_address' => $email,
            "merge_fields"  => [
                "FNAME" => $first_name,
                "LNAME" => $last_name,
            ],
        ];

        $lists = (array)$mailchimp->searchMembers->search($email);
        $exact_matches = (array)$lists['exact_matches'];
        if (isset($exact_matches['total_items'])) {
            $total_items = $exact_matches['total_items'];
            if ($total_items == 0) {
                $lists = $mailchimp->lists->addListMember('085b5e3db0', $data);
            } else {
                $member = (array)$exact_matches['members'][0];
                $lists = $mailchimp->lists->updateListMember('085b5e3db0', $member['id'], $data);
            }
        }


    } catch (BadResponseException  $e) {
        return $e->getCode() . " because " . $e->getResponse()->getBody()->getContents();

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        return $e->getCode() . " because " . $e->getResponse()->getBody()->getContents();

    } catch (\Exception $e) {
        return $e->getCode() . " because " . $e->getMessage();

    }

    return $lists;
});

Route::get('/orders/export', function () {
    return Excel::download(new RatingsExport, 'all_numbers.xlsx');
});
Route::get('/orders/show', function () {
    $orders = Order::all();

    return view('orders', compact('orders'));
});
Route::get('/orders/store', function () {
    $salla = new SallaWebhookService('48bbd359c4561d01d92c831f3d21600712441f5a0934e11e411963e0c22d97c768f64db6275e6dd9daad3058bb568f9aa18b');

    Order::whereNotIn('id', [12412124])->delete();


    foreach (range(1, $salla->getOrders(1)['pagination']['totalPages']) as $key => $page) {
        FirstLevel::dispatch($page)->delay(now()->addSeconds(3 + $key));
    }
});


Route::any('/training', function (Request $request) {
    $success = '';
    ini_set("pcre.backtrack_limit", "5000000");
    if ($request->isMethod('post')) {
        $name = $request->name;
        $email = $request->email;
        $key = 'training';
        $mpdf = '';
        $view = '';
        if (isArabic($name)) {
            $mpdf = getArabicPdf();
            $view = 'arabic';
        } else {
            $mpdf = getEnglishPdf();
            $view = 'english';
        }


        $mpdf->useAdobeCJK = true;


        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetDirectionality('rtl');
        $mpdf->charset_in = 'UTF-8';

        $path = public_path('images/certificate.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $mpdf->WriteHTML(view('pdf.' . $view, compact('base64', 'name'))->render());
        $mpdf->Output('pdf/certificate-' . $key . '.pdf', 'F');
        Mail::to($email)->send(new CerMail($key, $name));
        $success = 'تم بنجاح';

    }

    return view('training', compact('success'));
});

Route::get('/alammari-emails', function (Request $request) {
    ini_set("pcre.backtrack_limit", "5000000");
    $to = [
        ['name' => 'أسامة الطعمة ', 'email' => 'altoama@outlook.com'],
        ['name' => 'منال شجاع جعيثن الجعيثن', 'email' => 'asd-caring4u@windowslive.com'],
    ];

    foreach ($to as $key => $reviver) {
        $name = $reviver['name'];
        $email = $reviver['email'];
        $mpdf = '';
        $view = '';
        if (isArabic($name)) {
            $mpdf = getArabicPdf();
            $view = 'arabic';
        } else {
            $mpdf = getEnglishPdf();
            $view = 'english';
        }


        $mpdf->useAdobeCJK = true;


        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetDirectionality('rtl');
        $mpdf->charset_in = 'UTF-8';

        $path = public_path('images/certificate.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $mpdf->WriteHTML(view('pdf.' . $view, compact('base64', 'name'))->render());
        $mpdf->Output('pdf/certificate-' . $key . '.pdf', 'F');
        dispatch(new QueueJob($email, $key, $name));
    }
})->name('pdf.demo.stream');


Route::get('/insert-new-codes', function () {

    $codes = [
        'b36j5kUw272f3fVbJc',
        'b36j5TUj292f34V7Kd',
        'b36j5gUD2t2835V2L5',
        'b36j5QUy2M2530V2M7',
        'b36j5iUQ282036V8N2',
        'b36j5NUc2r2336V5P0',
        'b36j5fU3252539V1Qf',
        'b36j5TUx2X2035V3Rb',
        'b36j5ZUe2b283aVbS8',
        'b36j5VUT2j2139V5T8',
        'b36j5tUE2U2730VbU4',
        'b36j5yUT2E283bV4Va',
        'b36j5sUu2D213fVcW9',
        'b36j5kUL2w2938VdX8',
        'b36j5sUp2M2d33V4Yf',
        'b36j5kUD2i203fVeZ6',
        'b36j5cUd2X2b34V2a5',
        'b36j5SUs2G2933V6b6',
        'b36j5iUD2v253dVcc6',
        'b36j5LUg2P2736Vcdc',
        'b36j5rUN2P2632Vae2',
        'b36j5LU82b2933V3f4',
        'b36j5KU22W2e39V2gd',
        'b36j5HUX2b2e36V8h4',
        'b36j5EUC2S223bV9ia',
        'b36j5LUw2Q2c37Vcj4',
        'b36j56UL2n2b30V6ka',
        'b36j5bUX2f253bV4m2',
        'b36j5cUH2t2c36Vane',
        'b36j5YUN2M2730Vepb',
        'b36j5hUE2U2b3bV0q9',
        'b36j5rUK2b2c31Vcrc',
        'b36j5EUd2N2034V7sb',
        'b36j5iUu2t2031Vata',
        'b36j58Uu262736V6u6',
        'b36j5YUF2m2f3aVbv9',
        'b36j5hU62s2835V3we',
        'b36j5WUS2R2738Vdx8',
        'b36j5xU62T2330V8y2',
        'b36j5cUc2p283dV6z0',
        'b36j5xU7252a35We26',
        'b36j5TUh2N2f31W838',
        'b36j5pUv2k2a3eW148',
        'b36j5CUf2T2830W956',
        'b36j56UY2N283eW662',
        'b36j5vU72b2238Wb70',
        'b36j5hUZ2g2839We8f',
        'b36j5bU6292c3dWe96',
        'b36j5mU42D2e3fW3A9',
        'b36j5FUe2b273bWfB8',
        'b36j55UQ2T2133WdC0',
        'b36j5sUc2C2e3cWdD1',
        'b36j53US28243dWaE1',
        'b36j5mUc2Y2e3aWaF0',
        'b36j52UT272f3fW8G1',
        'b36j5NUA2w2332W4H4',
        'b36j5jUs2W2c32WbJf',
        'b36j5SUF2N2936W4K7',
        'b36j5LUm2B2b33WaL8',
        'b36j5KU32b2439W5Me',
        'b36j5fUq222237W4Ne',
        'b36j59UV2P233fWdP9',
        'b36j5KUW2a2e3aW4Q6',
        'b36j5DU52x2b33WfRb',
        'b36j5WU62R203fW0S7',
        'b36j5PUS2a2239W5T5',
        'b36j57UC2E2236W8Uf',
        'b36j5cUP2E2639W7Vd',
        'b36j5jUV222235W8We',
        'b36j5uUn2m2b39W1X4',
        'b36j5WUU2P2139W9Y7',
        'b36j5HUN2s2236W9Z1',
        'b36j5eUg2P2738W8af',
        'b36j5FUe2T213aW2b3',
        'b36j5DUB2X253cW0ca',
        'b36j5QUK2i2339W5de',
        'b36j5jUR2g2232W9eb',
        'b36j5xUn26293eW6f8',
        'b36j5wUY2L2837W3g2',
        'b36j5hUE292534Wah2',
        'b36j5GUj2N2930W4i9',
        'b36j5dU32j2034Wcj2',
        'b36j5JUT2D2b38Wak0',
        'b36j5fUT2c2338W1mb',
        'b36j5tUS2m2f36W9nd',
        'b36j5CUq2s293cW2pe',
        'b36j5gUM2J2537W1qe',
        'b36j5PU6272f37W6re',
        'b36j5TU32Q2a3eW8sf',
        'b36j5nUi2c203aWat3',
        'b36j5gUy2N2134W3ua',
        'b36j5qUP2B2033Wdv7',
        'b36j5MUf2P2538Wew7',
        'b36j5YU92q2339W6x8',
        'b36j5BUm242236W5y4',
        'b36j5hUy2d2639Wczd',
        'b36j5aUf2y2a39X22b',
        'b36j5dUp252134Xf32',
        'b36j5iUH2q2833Xf42',
        'b36j5tUq2Z2d3eX750',
        'b36j5XUK2K253eX465',
        'b36j5eUA2U2b33X371',
        'b36j5aUG2A2433X08c',
        'b36j5xUn24273aX096',
        'b36j5aUi2q2e31XbA4',
        'b36j5cUD2a2736X8B3',
        'b36j5HUn232e35X9Ca',
        'b36j53UD2q213dXeD5',
        'b36j57Uh2s2d34X5E8',
        'b36j5vUb2V2f3eX1F5',
        'b36j5HU92n2333X1Gb',
        'b36j5MUZ2h2332XbHa',
        'b36j5pUA2x2935X9Je',
        'b36j5jUt2X2b39X8Ka',
        'b36j5YUU23293cX4L8',
        'b36j5PUr2E2f35X4Md',
        'b36j5iU92m2431XfN9',
        'b36j5jUv222137XbPc',
        'b36j5MU32h263bXdQ8',
        'b36j5FUh2K2c36XbR1',
        'b36j5iUy2E2c3bX7Se',
        'b36j5JU82Y2a38X8T5',
        'b36j5kUg2T2a30XeUb',
        'b36j5iUD2M2835XfVa',
        'b36j53Uk2a2939X7W7',
        'b36j54Uu2T283eX8X3',
        'b36j53Ue2M2f3dXcYc',
        'b36j5pUB2H2e3dX3Z9',
        'b36j5pUX25293cX4ad',
        'b36j5JUX2m2d3eX0b8',
        'b36j5NUG2X2031Xcc7',
        'b36j5MUK2d2b3bX0d8',
        'b36j5tU6282733Xfe4',
        'b36j59Un2K273eX3f6',
        'b36j5UUa262539X8gc',
        'b36j56UP222339X7h9',
        'b36j5JUQ2R2b3dX3i3',
        'b36j5dUE2a2732Xajf',
        'b36j5vUn282338Xdk8',
        'b36j5yUr2d2e3eX1m7',
        'b36j5XUF2e213dX4nd',
        'b36j56Ua2x2738X3p7',
        'b36j5UUG242e39Xbq0',
        'b36j5aUP2b2c3bXdre',
        'b36j5uUc2w2330X9sb',
        'b36j5jUT2L2135Xdte',
        'b36j5jUj2j2031X5u4',
        'b36j5BUQ2x253eXfv3',
        'b36j5kU72Y2a35Xdwf',
        'b36j5dUq2Q273bX6x2',
    ];

    foreach ($codes as $code) {
        Code::create([
            'code' => $code,
        ]);
    }


    return "Done";
});
Route::get('/info', function () {
    $emails = Email::count();
    $allCodes = Code::count();
    $redeemedCodes = $code = Code::where('redeemed', 1)->count();
    $players = Player::count();

    return view('info', compact('emails', 'allCodes', 'redeemedCodes', 'players'));

});

Route::any('/emails-insert', function (Request $request) {

    if ($request->isMethod('post')) {
        Email::create([
            'username'   => $request->input('email'),
            'password'   => $request->input('password'),
            'blocked_to' => now()->subDay(),
        ]);
    }
    $emails = Email::all();

    return view('emails', compact('emails'));

});

Route::any('/emails-clear', function (Request $request) {


    $emails = Email::all();

    return view('emails', compact('emails'));

});


Route::any('/block-email/{email}', function ($email) {


    Email::where('username', $email)->update([
        'blocked_to' => now()->addHour(),
    ]);

    return "Done";

});


Route::any('/python-download', function () {


    return view('python-download');

});
