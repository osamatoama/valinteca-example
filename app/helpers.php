<?php


use App\Jobs\HaqoolLoopPages;
use App\Jobs\HaqoolPullOrderInvoiceJob;
use App\Models\HaqoolOrder;
use App\Models\PricesProducts;
use App\Services\SallaWebhookService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

function getArabicPdf()
{
    return new \Mpdf\Mpdf([
        'format'   => 'A4-L',
        'fontDir'  => array_merge([
            __DIR__ . '/../public/css',
        ]),
        'fontdata' => [
            'tajawal' => [
                'R'          => "Tajawal-Regular.ttf",
                'L'          => "Tajawal-Light.ttf",
                'B'          => "Tajawal-Bold.ttf",
                'useOTL'     => 0xFF,
                'useKashida' => 75,
            ],
        ],

        'autoScriptToLang'    => true,
        'ignore_invalid_utf8' => true,

        'default_font'         => 'Tajawal',
        'autoArabic'           => true,
        'cacheCleanupInterval' => 1,
    ]);
}

function getEnglishPdf()
{
    return new \Mpdf\Mpdf([
        'format'               => 'A4-L',
        'fontDir'              => array_merge([
            __DIR__ . '/../public/css',
        ]),
        'fontdata'             => [
            'dancing' => [
                'R'          => 'DancingScript-VariableFont_wght.ttf',
                'useOTL'     => 0xFF,
                'useKashida' => 75,

            ],
        ],
        'default_font'         => 'Dancing Script',
        'autoArabic'           => true,
        'cacheCleanupInterval' => 1,
    ]);
}

function uniord($u)
{
    // i just copied this function fron the php.net comments, but it should work fine!
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));

    return $k2 * 256 + $k1;
}

function isArabic($str)
{
    if (mb_detect_encoding($str) !== 'UTF-8') {
        $str = mb_convert_encoding($str, mb_detect_encoding($str), 'UTF-8');
    }

    /*
    $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
    $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
    */
    preg_match_all('/.|\n/u', $str, $matches);
    $chars = $matches[0];
    $arabic_count = 0;
    $latin_count = 0;
    $total_count = 0;
    foreach ($chars as $char) {
        //$pos = ord($char); we cant use that, its not binary safe
        $pos = uniord($char);

        if ($pos >= 1536 && $pos <= 1791) {
            $arabic_count++;
        } else if ($pos > 123 && $pos < 123) {
            $latin_count++;
        }
        $total_count++;
    }
    if (($arabic_count / $total_count) > 0.6) {
        // 60% arabic chars, its probably arabic
        return true;
    }

    return false;
}


function updatePrice(PricesProducts $product)
{
    ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)');
    $url = $product->url;
    $content = file_get_contents($url);
    $salla = false;
    if (Str::contains($content, 'cdn.salla.sa')) {
        $salla = true;
    }
    if ($salla) {

        $product->update(getPriceFromSallaWebsite($content));


        return;
    }

    return;

    $urlMaps = [
        'goldblv.com' => '/<span class="number js-product-price(.|\n)*?<\/span>/',
        'default'     => '/<span class="product-price(.|\n)*?<\/span>/',
    ];
    $host = parse_url($url)['host'];

    $regex = isset($urlMaps[$host]) ? $urlMaps[$host] : $urlMaps['default'];
    if (filled($regex)) {
        preg_match($regex, $content, $matches);
        if (isset($matches[0])) {
            $product->update([
                'price' => preg_replace('/(<([^>]+)>)/i', '', $matches[0]),
            ]);
        }

    }

}

function getPriceFromSallaWebsite($content)
{
    $to_update = [];

    preg_match('/<p class="product-details__price(.|\n)*?<\/p>/', $content, $priceContainerMatch);

    preg_match('/<span class="product-price(.|\n)*?<\/span>/', $priceContainerMatch[0], $original_price);
    preg_match('/<span class="price-before(.|\n)*?<\/span>/', $priceContainerMatch[0], $current_price);
    preg_match('/<span id="price-after(.|\n)*?<\/span>/', $priceContainerMatch[0], $after_price);

    if (isset($original_price[0])) {
        $to_update['price_before'] = clearPrice($original_price[0]);
    }
    if (isset($current_price[0])) {
        $to_update['price_before'] = clearPrice($current_price[0]);
    }
    if (isset($after_price[0])) {
        $to_update['price_after'] = clearPrice($after_price[0]);
    }


    return $to_update;
}


function clearPrice($content)
{
    return preg_replace('/(<([^>]+)>)/i', '', $content);
}


function ss()
{
    //ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)');
    $url = 'https://www.mail-tester.com';
    $content = file_get_contents($url);
    sleep(5);
    dd($content);


}


if ( ! function_exists('getWebsiteContent')) {
    function getWebsiteContent($url)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // this will follow redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // stop after 10 redirects to prevent infinite loops

        // $output contains the output string
        $output = curl_exec($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // close curl resource to free up system resources
        curl_close($ch);

        return [
            'status' => $statusCode,
            'output' => $output,
        ];
    }
}


function generate_header($signature, $date, $datestamp)
{
    $headers['Accept'] = 'application/json';
    $headers['Content-Type'] = 'application/json';
    $headers['X-Mint-Date'] = $date;
    $headers['Authorization'] = sprintf('algorithm="%s",credential="%s",signature="%s"', 'hmac-sha256',
        config('mintroute.MINT_ACCESS_KEY') . '/' . $datestamp, $signature);
    $http_headers = [];
    foreach ($headers as $k => $v) {
        $http_headers[] = "$k: $v";
    }

    return $http_headers;
}


function get_current_balance()
{


    $request_json = '{"username":"' . config('mintroute.MINT_USERNAME') . '","data":{"currency":"USD"}}'; //'{ "username": "sahwah.single" "data":{"ean":"PRODUCT EAN HERE","terminal_id":"Server001","request_type":"purchase", "response_type": "short"}}';

    $pay_load = json_decode($request_json, true);

    $request_method = 'POST';
    $raw_pay_load = http_build_query($pay_load);
    $date = gmdate('Ymd\THis\Z');
    $timestamp_for_signing = substr($date, 0, 13);
    $datestamp = substr($date, 0, 8);

    $str_to_sign = $request_method . $raw_pay_load . $timestamp_for_signing;

    $signature = base64_encode(hash_hmac('sha256', $str_to_sign, config('mintroute.MINT_SECRET_KEY'), true));
    $headers = generate_header($signature, $date, $datestamp);

    //Curl Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_URL, config('mintroute.urls.get_current_balance'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $response = substr($response, $header_size);
    if ( ! empty(curl_error($ch))) {
        echo curl_error($ch);

        return 'error happened';
    }
    curl_close($ch);
    dd($response);


    $response = json_decode($response, true);

    return $response['data']['available_balance'] . ' ' . $response['data']['currency'];


}


function get_brand($id)
{


    $request_json = '{"username":"' . config('mintroute.MINT_USERNAME') . '","data":{"category_id":"' . $id . '"}}';

    $pay_load = json_decode($request_json, true);

    $request_method = 'POST';
    $raw_pay_load = http_build_query($pay_load);
    $date = gmdate('Ymd\THis\Z');
    $timestamp_for_signing = substr($date, 0, 13);
    $datestamp = substr($date, 0, 8);

    $str_to_sign = $request_method . $raw_pay_load . $timestamp_for_signing;

    $signature = base64_encode(hash_hmac('sha256', $str_to_sign, config('mintroute.MINT_SECRET_KEY'), true));
    $headers = generate_header($signature, $date, $datestamp);

    //Curl Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_URL, config('mintroute.urls.brand'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $response = substr($response, $header_size);
    if ( ! empty(curl_error($ch))) {
        echo curl_error($ch);

        return 'error happened';
    }
    curl_close($ch);

    $response = json_decode($response, true);


    return $response;


}


if ( ! function_exists('get_salla_merchant_info')) {
    function get_salla_merchant_info($token)
    {
        try {
            $client = new Client();
            $response = $client->get('https://accounts.salla.sa/oauth2/user/info', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return $e;
        }

    }
}


function removeSpecialCharacters($string)
{
    $string = str_replace(['[\', \']'], '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1',
        $string);
    $string = preg_replace(['/[^a-z0-9]/i', '/[-]+/'], '-', $string);
    $string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);

    return trim($string, '-');
}


function pullHaqoolOrders($pages)
{
    $api_key = 'ory_at_aGDXAr3TFDTYR7wgoDK2qswo9dYZ0dHxw77QgChx_Tg.h_HmxbfNSKwlnaV-HNkUGLT841RCMXa4ZymgkacSIgg';


    foreach (array_chunk(range(1, $pages), 50) as $pages) {

        dispatch(new HaqoolLoopPages($pages, $api_key));
    }


    $salla = new SallaWebhookService($api_key);
    $invoices = HaqoolOrder::whereNull('invoice_number')->get();
    foreach ($invoices as $invoice) {
        $order = $salla->getOrder($invoice->salla_order_id);
        dispatch(new HaqoolPullOrderInvoiceJob($order['data'], $api_key))->onQueue('pull-order');
    }

}

