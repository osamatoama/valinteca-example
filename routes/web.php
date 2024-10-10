<?php

use App\Exports\AbayaExport;
use App\Exports\BestShieldOrders;
use App\Exports\DataExport;
use App\Exports\HaqoolInvoices;
use App\Exports\HaqoolOrders;
use App\Exports\OrdersExport;
use App\Exports\RatingsExport;
use App\Exports\SlimShClients;
use App\Http\Controllers\TapPaymentController;
use App\Jobs\AbayaJob;
use App\Jobs\AutoGoldMailJob;
use App\Jobs\AywaCardsLoopPages;
use App\Jobs\BestShieldCheckPage;
use App\Jobs\FirstLevel;
use App\Jobs\HaqoolPullOrderInvoiceJob;
use App\Jobs\HaqoolPullProductsJob;
use App\Jobs\PullNavaImagesJob;
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
use App\Models\HaqoolOrder;
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

    return bcrypt('admin');
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

    return $yuqueClient->postHttpRequest(config('yuque.urls.user_products_list'), [
        'page'     => request('page', 1),
        'per_page' => request('per_page', 10),
    ]);

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
        echo $code . '<br /> <br /><br />';
    }
});


Route::get('pdf-example-1', function () {

    app(PdfExportService::class, [
        'data'     => [
            'data' => [],
        ],
        'view'     => "emails.ticket.index",
        'filename' => 'home',
        'height'   => 420,
        'width'    => 240,
    ])->export();

});


Route::get('pdf-example-2', function () {

    app(PdfExportService::class, [
        'data'     => [
            'data' => [],
        ],
        'view'     => "pdf.arabic2",
        'filename' => 'home',
        'height'   => 420,
        'width'    => 240,
    ])->export();

});


Route::any('/pdf-example-3', function (Request $request) {

    ini_set("pcre.backtrack_limit", "5000000");
    $mpdf = getArabicPdf();
    $view = 'arabic2';


    $mpdf->useAdobeCJK = true;


    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;
    $mpdf->SetDirectionality('rtl');
    $mpdf->charset_in = 'UTF-8';

    $path = public_path('images/arabic.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $mpdf->WriteHTML(view('pdf.' . $view, compact('base64'))->render());
    $mpdf->Output('pdf/ticket.pdf', 'I');


    //    return view('training', compact('success'));
});


Route::any('/send-auto-gold-emails', function (Request $request) {

    $emails = [
        'alarbash.marina@gmail.com',
        'mobilogest@gmail.com',
        'Jawharatalmasa@gmail.com',
        'sharef050523@icloud.com',
        'lmsahalmas@gmail.com',
        'm.alfadda@gmail.com',
        'Ghina.jewelery@gmail.com',
        'moha_5522@hotmail.com',
        'kemosparkl@gmail.com',
        'mohdnmr@gmail.com',
        'alsallum.a@gmail.com',
        'm.b.aljady@gmail.com',
        'selas.gold@gmail.com',
        'zid.ndj.refaei@gmail.com',
        'eiar2030@gmail.com',
        'qasim_sh@live.com',
        'absba_com2008@hotmail.com',
        'abdullahalqasimi65@gmail.com',
        'ndj.testing@gmail.com',
        'zy.jewelry91@gmail.com',
        'ibra.z.1671@icloud.com',
        'moath055389@gmail.com',
        'ugd1416@hotmail.com',
        'dorarrgold@gmail.com',
        'Salyh2009@gmail.com',
        'shibaforgold@gmail.com',
        'rtl2002@hotmail.com',
        'hamahgold@gmail.com',
        'mnm999000@gmail.com',
        'ytsalamrigoold@gmail.com',
        'info@arbashj.com',
        'aaa.sss.21@hotmail.com',
        'zomorod.jew@gmail.com',
        'hh0506517558@gmail.com',
        'Hhaaider212@gmail.com',
        'al.qemmah.althahabia@gmail.com',
        'fadi.aljenneyat@gmail.com',
        'Gold79A.khibrra@gmail.com',
        'store@almuhaisen.com',
        'Farisjewellery2@gmail.com',
        'Fajeralbahrainj@gmail.com',
        'albaggshi.t@gmail.com',
        'hakaya112@hotmail.com',
        '7akaya.gold@gmail.com',
        'branddealco@gmail.com',
        'info@necklss.com',
        'asjdjewelry@gmail.com',
        'nemergold@gmail.com',
        'r017022@gmail.com',
        'thaha1mm@gmail.com',
        'jewelryalwayil@gmail.com',
        'alarbashmdh@gmail.com',
        'Ellajewellery361@gmail.com',
        'mon3maldoukhi@gmail.com',
        'deerjewelry.sa@outlook.com',
        'a0506963131@gmail.com',
        'alhamedahtop@gmail.com',
        'alghunaim.jew@gmail.com',
        'obal.gold@icloud.com',
        'Glitterjewelery@gmail.com',
        'glamor.j.sa@gmail.com',
        'ahmedmooodyy0@gmail.com',
        's.nas720@gmail.com',
        'anwar.jewelry@hotmail.com',
        'alwaleed20054@gmail.com',
        'Maries.crownn@gmail.com',
        'ali@lavinjewellry.com',
        'anmsvi@outlook.com',
        'admin@rabighgold.com',
        'ghazaal.jewellery@gmail.com',
        'diblati.2030@gmail.com',
        'hassan.hossam911@yahoo.com',
        'mo.alrasheed.store@gmail.com',
        'faizah.alasmari@gmail.com',
        'ooalamoudi96+1@gmail.com',
        'briqalmaas@gmail.com',
        'lavinjewellry2030@gmail.com',
        'albagshigoldapp@gmail.com',
        'loloahalzahraa@gmail.com',
        'alamoudig1@gmail.com',
        'aliyah.jewelry@hotmail.com',
        'rjwe1100@gmail.com',
        'aseam6281@gmail.com',
        'info@Algarawi.org',
        'kroomsuod@gmail.com',
        'arbashpalace@gmail.com',
        'durah.gazlan@gmail.com',
        'sherin.makasseb.seo@gmail.com',
        'twaaq.sa@gmail.com',
        'abdullah0533115688@gmail.com',
        'Hussain.almohammedali1@gmail.com',
        'jaldhhb2019@gmail.com',
        'astw6971@gmail.com',
        'goldpalace81@gmail.com',
        'goldlandjewellery1@gmail.com',
        'A.F2008@HOTMAIL.COM',
        'mo.ali.mohammad@gmail.com',
        'go1991ld@gmail.com',
        'alammarigold9999@hotmail.com',
        'alnasserjewelry@gmail.com',
        'legendjewelry1@gmail.com',
        'totahalazmi1991@gmail.com',
        'alghunaim.ib10@gmail.com',
        'amin@oma-marketing.com',
        'txx196@gmail.com',
        'ndj.orders@gmail.com',
        'alsaqabigold2@gmail.com',
        'gold875k@gmail.com',
        'gold.aaj@gmail.com',
        '7ced1961@gmail.com',
        'f.alasmari2013@hotmail.com',
        'Elegancenecklacee@gmail.com',
        'info@raffinato.sa',
        'salahammari@hotmail.com',
        '7ASSONH7@GMAIL.COM',
        'yaseno1966@gmail.com',
        'zm470517@gmail.com',
        'ghasaqjewelry@gmail.com',
        'emadads40@gmail.com',
        'Hs773038772hs852hosamshhary@gmail.com',
        'knooz@oma-marketing.com',
        'Faarsko@gmail.com',
        'rii@hotmail.com',
        'zkihsn@gmail.com',
        'alsaada85jewelry@gmail.com',
        'lamas.u.l.c@hotmail.com',
        'bassam302@hotmail.com',
        'Codersaud+1@gmail.com',
        'Enxl77@gmail.com',
        'shahed.olabi1996@gmail.com',
        'hussain-1992@live.com',
        'a7md_7sn88@hotmail.com',
        'rowad.m55@gmail.com',
        'ghassan.basrak@hotmail.com',
        'maryscrown.store@gmail.com',
        'moomo11209@gmail.com',
        'laalmhmdly@gmail.com',
        'mohmidk5@outlook.com',
        'alshaya.jw@gmail.com',
        'Tkno5.store@gmail.com',
        'Masat.Alsaada@gmail.com',
        'sales@marinajewlry.com',
        'lamya.cs@gmail.com',
        'mlwy854@gmail.com',
        'b.alharbi@zid.sa',
        'ahmedashra492@gmail.com',
        'qalshefa@gmail.com',
        'kanaezads@gmail.com',
        'mazzouka96@gmail.com',#
        'alarbashjewels0@gmail.com',
        'murtadahahaha@gmail.com',
        'sondman.y@gmail.com',
        'shaden@mas-jewel.com',
        'alwisamalrafii@gmail.com',
        'fyz.gold@gmail.com',
        'kunoooz@outlook.com',
        'goooo3177@gmail.com',
        'slaaah33@gmail.com',
        'y.alnemer.j@gmail.com',
        'jwda4704@gmail.com',
        '1069@qaraterp.com',
        'ama3z1998@gmail.com',
        'serene.saudi@gmail.com',
        'jaw.khaial@gmail.com',
        'roua.golden@gmail.com',
        'un.je.2017@gmail.com',
        'pr.ring221@gmail.com',
        'ezzaddeenhoven@outlook.com',
        'support@laster.sa',
        'omar.sagabi@gmail.com',
        'qzsksa@oma-marketing.com',
        'info@refalgulf.com',
        'baqshi@dgstechno.com',
        'perlajewelrysa@gmail.com',
        'a.aldajani93@gmail.com',
        'info@sbaik.sa',
        'hamad.alnami_alsarh@yahoo.com',
        'qmralandlls@gmail.com',
        'riyadh.almasah@gmail.com',
        'laylatyjewelry@gmail.com',
        'coool.m112@hotmail.com',
        'coins7718@gmail.com',
        'dawood.rosegold@gmail.com',
        'Roof.goldd@gmail.com',
        'solitaire_gold@hotmail.com',
        'alooymoha@gmail.com',
        'hsn.nmr@gmail.com',
        'shma70qassim@gmail.com',
        'alhumud_jw@outlook.com',
        'taj@al-fakhamah.com',
        'shoogalyami963@gmail.com',
        'athar_111@icloud.com',
        'attasjewellery1@gmail.com',
        's.gr511@yahoo.com',
        'dr.omar.t.m@hotmail.com',
        'altajalraaqi@gmail.com',
        'rawabialaried@gmail.com',
        'Alrayagoldenn@gmail.com',
        'ghjgxiyfigci@gmail.com',
        'drtaj.co@gmail.com',
        'a.khalil+4@neoxero.com',
        'adyarjewellery@gmail.com',
        'Lumirgold@gmail.com',
        'abalkhail.jewelry@gmail.com',
        'rdiyfvfzbw@zam-partner.email',
        'myjewel.j@gmail.com',
        'jamelacorner.sa@gmail.com',
        'nashigold@gmail.com',
        'hakeemtraheeb22@gmail.com',
        'Mo.ali.mohammad2@gmail.com',
        'info@ruby.sa',
        'info@hikalaraba.com',
        'hdy504165@gmail.com',
        'lubatishop@gmail.com',
        'mido61061@icloud.com',
        'customer.service@dewanaldahab.com',
        's-bhr@hotmail.com',
        'sabayikalmahd@gmail.com',
        'alaajewelry@outlook.sa',
        'nafgold@nafgold.com',
        'aqdalwafa.co@gmail.com',
        'info@faris.sa',
        'info@mas-jewel.com',
        'eeammar@gmail.com',
        'aldukhi.for.gold@gmail.com',
        'knoozjewels@gmail.com',
        'nayagoldbars@gmail.com',
        'fqaishjewellery@hotmail.com',
        'reema.b@dmusc.com',
        'emadhamoudah6@gmail.com',
        'it.malak.tech@gmail.com',
        'abd@alammarico.com',
        'tylosjewelry@gmail.com',
        'info@lavinjewellry.com',
        'salha@smartarrow.sa',
        'dr.gold9999@gmail.com',
        'rubajewel1@gmail.com',
        'gold.alshefa@gmail.com',
        'Marketing@taiba.com',
        'demas.jewellery@gmail.com',
        'alredajewellary@gmail.com',
        'khalidholllow@gmail.com',
        'moodii2050@gmail.com',
        'alsaabjewelery@gmail.com',
        'khaze990@gmail.com',
        'emasellsa@gmail.com',
        'manaf1243@gmail.com',
        'krgstore2@gmail.com',
        'bothabet.gold23@gmail.com',
        'saad-7alabi9@hotmail.com',
        'yaseno.1966@gmail.com',
        'alyafiejewelery@gmail.com',
        'Marketing@lamarjewellery.com',
        'Info@qzs-ksa.com',
        'zak4lifepodcast@gmail.com',
        'info@aribgold.com.sa',
        'alshalawijewelry@gmail.com',
        'ahmadaldahwali@navajewellery.sa',
        'a.maher@navajewellery.sa',

    ];
    foreach ($emails as $email) {
        dispatch(new AutoGoldMailJob($email));
    }

});

Route::any('/pull-nava-images', function (Request $request) {

    \Artisan::call('migrate:fresh --seed ');
    $api_key = 'ory_at_yRw98x70LqtPaHwjsdgTSwyBJ3O3zWbCukR1J6txIJU.zceMn2CP28JNp6fCvZ8uO0CVx8B1e3UFwn3F7MqbJm4';
    $salla = new SallaWebhookService($api_key);
    $products = $salla->getProducts();


    foreach (range(1, $products['pagination']['totalPages']) as $page) {
        dispatch(new PullNavaImagesJob($api_key, $page));
    }

});

Route::any('/pull-aywa-cards', function (Request $request) {

    $api_key = 'ory_at_Rh20QltusYnf6i40H7N9MUBgsDLJdgAMuaILXwonT3Y.SNaYDx-Yv8lQjTSKDUGdCvF3ImZ3gO2pnHW24xgQVzM';


    foreach (array_chunk(range(1, 27500), 500) as $pages) {
        dispatch(new AywaCardsLoopPages($pages));
    }


});


Route::any('/pull-haqool-products', function (Request $request) {
    $api_key = 'ory_at__0229vjtyW_VX1tUl4M1BwFsttu_yfteFJ99Y8wqRxs.tKKnhPGkTpGl8aIZY2DrHquiDKt8KDbCNEBBZZWuAlY';
    $salla = new SallaWebhookService($api_key);


    foreach (range(1, 214) as $page) {
        dispatch(new HaqoolPullProductsJob($page, $api_key));
    }
});


Route::any('/pull-haqool-orders/{pages}', function ($pages) {
    pullHaqoolOrders($pages);
    sleep(2);

    return redirect()->to('/view-haqool-orders');


});

Route::any('/retry-empty-haqool-invoices', function (Request $request) {
    $api_key = 'ory_at_sfyIZg2otcS7e9nZL7TeOsFxScHCMAuKU5k2pLwKt6U.k7aZ4IN9AsQF6m8suBMjalusBkc_ZEjlK1ovqOHYMO8';

    $invoices = HaqoolOrder::whereNull('invoice_number')->get();

    foreach ($invoices as $invoice) {
        dispatch(new HaqoolPullOrderInvoiceJob($invoice->salla_order_id, $api_key))->onQueue('pull-order');
    }
});


Route::any('/pull-best-shield-orders', function (Request $request) {
    $api_key = 'ory_at_udjzu3ce7VmRiWo6j92GxE5VjlQYFYKPI2RTdKalR-M.Xb-LGi1gYNoNSrC0nRluosRXUDnjVWEBvt8XNkl3C-0';


    foreach (range(1, 50) as $page) {
        dispatch(new BestShieldCheckPage($page));
    }
});


Route::get('/best-shield-export-orders', function () {
    return Excel::download(new BestShieldOrders(), 'best-shield.xlsx');
});


Route::get('/haqool-export-orders', function () {
    return Excel::download(new HaqoolOrders(), 'haqool.xlsx');
});


Route::get('/haqool-export-invoices', function () {
    return Excel::download(new HaqoolInvoices(), 'haqool_invoices.xlsx');
});


Route::any('/view-haqool-orders', function (Request $request) {
    $firstDate = HaqoolOrder::orderBy('order_date', 'ASC')->first()->order_date;
    $lastDate = HaqoolOrder::orderBy('order_date', 'DESC')->first()->order_date;
    $orderItems = HaqoolOrder::count();
    $orders = HaqoolOrder::distinct('order_number')->count();
    $emptyInvoices = HaqoolOrder::whereNull('invoice_number')->count();
    $defaultJobs = DB::table('jobs')->where('queue', '=', 'default')->count();
    $pullOrderJobs = DB::table('jobs')->where('queue', '=', 'pull-order')->count();
    $failed_jobs = DB::table('failed_jobs')->get();

    return view('haqool-orders',
        compact('orders', 'orderItems', 'firstDate', 'lastDate', 'failed_jobs', 'defaultJobs', 'pullOrderJobs',
            'emptyInvoices'));
});




