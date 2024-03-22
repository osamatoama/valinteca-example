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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use robertogallea\LaravelPython\Services\LaravelPython;

Route::get('/', function () {

    return "<h1>Hello Valinteca</h1>";
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
        'FX5LjHPa2K2039NdW3',
        'FX5LjpPw2D2e39N0X3',
        'FX5LjTPT2U2934N1Y4',
        'FX5LjqPw2t2035N0Z8',
        'FX5Lj8PS2q223eN4a5',
        'FX5LjiPe2r2433N3b7',
        'FX5LjdPU2s2632N6c6',
        'FX5LjAPF2s2038N5dd',
        'FX5LjNPj242239N7e0',
        'FX5LjeP72j2037N4f3',
        'FX5LjGP9272331N0g6',
        'FX5LjLPi24223bNch5',
        'FX5LjJPC2V243aN1i8',
        'FX5LjXP32D2c36Nejd',
        'FX5LjRPt2Q2a31N5k7',
        'FX5LjGPc252938N9mb',
        'FX5LjsP42K2132N5n3',
        'FX5LjjPC2Y2d35Nep1',
        'FX5LjdPY252f39Ncq6',
        'FX5LjfPD2u2331N9r1',
        'FX5LjCPE252531Nes6',
        'FX5LjHPK2m2038Nct8',
        'FX5Lj6Pb2i2431N8uf',
        'FX5LjZP92W2331N8v1',
        'FX5LjYPK2Q2130N9w8',
        'FX5LjwPZ2m293eN2xc',
        'FX5Lj3PT2p2c39N6y6',
        'FX5Lj7Px232b35N5z6',
        'FX5LjQPN2Z2e3eP82c',
        'FX5LjUP52Y2a30P338',
        'FX5LjAP22X2e37P040',
        'FX5LjxP52r2d36P35f',
        'FX5LjWP92E2e34Pc6d',
        'FX5LjFPU292137P776',
        'FX5LjWP32S2d3bPa8b',
        'FX5LjuPi232c38P69b',
        'FX5LjUPW2F2831PbA3',
        'FX5LjJPb2x2538PcB0',
        'FX5LjKP32M2432P3Cc',
        'FX5LjePG2B2b3bPaD4',
        'FX5LjxPB2B2333PdE7',
        'FX5LjVPA2y2e37PaF7',
        'FX5Lj8Pe2t203aPfG6',
        'FX5LjMPf2N223fPaHa',
        'FX5LjFPC2A233aPcJf',
        'FX5LjfPs2s2d39P3K9',
        'FX5LjTPM2Q2031P6Lb',
        'FX5LjTPd222937P6M4',
        'FX5LjSPi2m2534P6Ne',
        'FX5LjmPP242437PeP6',
        'FX5LjhP82E2336P9Q7',
        'FX5LjdPb292836P4R5',
        'FX5LjdPV2m2233PdS1',
        'FX5LjXPb2E2a3eP0T3',
        'FX5LjePq2R263bPbU5',
        'FX5LjnPW252b30P9V9',
        'FX5LjfPj2Q2330P6W7',
        'FX5LjqPD2n2c30P2Xf',
        'FX5LjcPd2J2f39P9Y8',
        'FX5LjQPC2S2d35PeZ8',
        'FX5LjEPt2Y2435Pfa5',
        'FX5LjDPK2v2239P3bf',
        'FX5LjLPw2R2d32P3c4',
        'FX5LjsPF232230Pade',
        'FX5Lj8Pt2c2832P4e4',
        'FX5LjJPg292032P6ff',
        'FX5LjMP92s2335P7g5',
        'FX5LjWPy2r2738Pdh4',
        'FX5Lj6Pb2G213bP4i4',
        'FX5LjPPk2T2331P9j9',
        'FX5LjpPj28253fPfk0',
        'FX5LjPPw2R2436P6mc',
        'FX5LjKP4292e3bP7n0',
        'FX5LjVPg2N2036P2p3',
        'FX5LjHPZ2G2c3aP1q5',
        'FX5LjtPc2h283bP8rd',
        'FX5LjmPi2r273cP7sb',
        'FX5LjSPF2b2f37P1tb',
        'FX5LjJP62D2130Pau0',
        'FX5LjYPT2i2039Pcv8',
        'FX5LjkP52V223bP1we',
        'FX5LjePD2D2e3dPexa',
        'FX5LjqPH2G2731Pfy3',
        'FX5LjyPk2h2c35Pbz6',
        'FX5Lj8P42H2934Qc26',
        'FX5LjPPg2e273eQ93b',
        'FX5LjrPU2P2c32Q141',
        'FX5LjhPu2c2330Qd51',
        'FX5LjKPD2T2034Q86b',
        'FX5LjHPX2g263bQ471',
        'FX5Lj3P52j233bQ88d',
        'FX5LjWPh2w2b31Qe9d',
        'FX5LjhPZ2E2e3aQ2A9',
        'FX5LjiPK2y2831Q5B8',
        'FX5LjDPR2m2d38Q2C5',
        'FX5LjFPZ2U2d39Q9Da',
        'FX5LjtPS2h2539Q8Ed',
        'FX5LjHPu2d213fQ5F9',
        'FX5LjePF2b293dQ7Ga',
        'FX5Lj9PH2t2333QcH3',
        'FX5LjpPJ2x2f3aQ7J9',
        'FX5LjZPZ2f233dQ4K6',
        'FX5LjHP52F273eQ1Le',
        'FX5LjVPY2Y2f3dQ5M1',
        'FX5LjFPk2j2430Q2N9',
        'FX5LjmPk2K2b3bQaP0',
        'FX5Lj3Pf2W223dQ3Qa',
        'FX5LjiPh2S243cQ6R2',
        'FX5LjNPP2S2b35QbSc',
        'FX5LjjPH2h2b33Q7T5',
        'FX5LjdP72m2936Q0U2',
        'FX5LjbPR2M263fQcV3',
        'FX5LjJPg2B233dQ9Wf',
        'FX5LjJPw2V2b38QbX7',
        'FX5LjcPw2G2d34Q4Y4',
        'FX5LjNPi2m223eQ5Zb',
        'FX5LjSPj2T2e3fQba6',
        'FX5LjxPF2C2233Q0b0',
        'FX5LjQPc2L2435Q1cf',
        'FX5LjqP92b2b36Q2dc',

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

    return view('emails');

});


Route::any('/block-email/{email}', function ($email) {


    Email::where('username', $email)->update([
        'blocked_to' => now()->addHour(),
    ]);

    return "Done";

});

