<?php

use App\Exports\AbayaExport;
use App\Exports\DataExport;
use App\Exports\OrdersExport;
use App\Exports\RatingsExport;
use App\Exports\SlimShClients;
use App\Http\Controllers\TapPaymentController;
use App\Jobs\AbayaJob;
use App\Jobs\FirstLevel;
use App\Jobs\PythonCommand;
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
use App\Services\PdfExportService;
use App\Services\SallaWebhookService;
use App\Services\Yuque\YuqueClient;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use robertogallea\LaravelPython\Services\LaravelPython;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {

    return removeSpecialCharacters('‏uecFt5Xq2j293d3eZ6');
});


Route::get('test-an', function () {
    dump(get_salla_merchant_info('ory_at_sffvweKGQe1wttLG2X_iZbS7mOhMNEKgmNytaXmCrLQ.woiRhqGHq-tQ5INmugKyKIgGbQ-ClCAsbgj_Mx1QNcU'));
    dump(get_salla_merchant_info('ory_at_Hx7N76_QxJjC0HHX8xV0jNG-WCeCuk9MMZkmxt4U-nM.N1vD-HqxSlPy07GHdzwf3xDiLR2dN09gOinYqfw5-JA'));
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
    $emails = Email::orderBy('id', 'DESC')->get();

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


    foreach (range(1, 10) as $i) {
        PythonCommand::dispatch();
    }

    return view('python-download');

});

Route::get('yuque', function () {


    $yuqueClient = new YuqueClient;

    return $yuqueClient->postHttpRequest(config('yuque.urls.merchant_account_info'), [
        'page'     => request('page', 1),
        'per_page' => request('per_page', 10),
    ]);

});


Route::get('mintroute/balance', function () {

    return get_current_balance();

});


Route::get('qr-code', function () {

    $qrCodes = [];
    $qrCodes['simple'] = QrCode::size(150)->generate('https://vocally.valantica.com/');

    $qrCodes['changeColor'] = QrCode::size(150)->color(255, 0, 0)->generate('https://vocally.valantica.com/');
    $qrCodes['changeBgColor'] = QrCode::size(150)->backgroundColor(255, 0,
        0)->generate('https://vocally.valantica.com/');
    $qrCodes['styleDot'] = QrCode::size(150)->style('dot')->generate('https://vocally.valantica.com/');
    $qrCodes['styleSquare'] = QrCode::size(150)->style('square')->generate('https://vocally.valantica.com/');
    $qrCodes['styleRound'] = QrCode::size(150)->style('round')->generate('https://vocally.valantica.com/');

    foreach ($qrCodes as $code) {
        echo  $code . '<br /> <br /><br />';
    }
});


Route::get('pdf-example-1', function () {

    app(PdfExportService::class, [
        'data' => [
            'data' => [],
        ],
        'view' => "emails.ticket.index",
        'filename' => 'home',
        'height' => 420,
        'width' => 240,
    ])->export();

});


Route::get('pdf-example-2', function () {

    app(PdfExportService::class, [
        'data' => [
            'data' => [],
        ],
        'view' => "emails.test",
        'filename' => 'home',
        'height' => 420,
        'width' => 240,
    ])->export();

});





