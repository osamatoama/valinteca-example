<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media print {
            .wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }
        }
        @page {
            margin: 0 7px;
            padding: 0;
        }
        * {
            padding: 0;
            margin: 0;
            direction: rtl;
            /*font-family:   'Airal', 'Dastnevis', 'Helvetica Neue', 'Helvetica', 'Airal', Helvetica, Arial, sans-serif;*/
            /*font-family: 'Dastnevis';*/
            text-align: center !important;
        }

        body {
            font-family: 'Dastnevis', sans-serif;
            direction: rtl;
            text-align: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dir-ltr {
            direction: ltr !important;
        }

        .under-line {
            text-decoration: underline;
        }

        .fw-light {
            font-weight: 300;
        }

        .fw-medium {
            font-weight: 500;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-sm-size {
            font-size: 18px;
        }

        .text-md-size {
            font-size: 20px;
        }

        .text-lg-size {
            font-size: 22px;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .m-b-15 {
            margin-bottom: 15px;
        }

        .text-end {
            text-align: end;
        }

        .bg-gray {
            background-color: #e3e3e3;
        }

        .text-center {
            text-align: center;
        }

        .wrapper {
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-spacing: 0;
            text-align: right;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table td {
            padding: 10px;
        }

        header .wrapper {
            padding: 5px 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .website-info-wrapper {
            vertical-align: bottom;
        }

        .website-name {
            font-size: 25px;
            margin-bottom: 20px;
        }

        header table p {
            padding: 5px 0;
        }

        .invoice-info-wrapper p,
        .invoice-info-wrapper .tax-num {
            text-align: left;
        }

        .cod {
            width: fit-content;
            margin-right: auto;
            margin-bottom: 15px;
            padding: 10px 15px 5px;
            border: 2px solid #f3f3f3;
        }

        .tax-num img {
            width: 250px;
            height: 60px;
        }

        .client-info {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .order-info {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .order-details {
            border: 2px solid #eee;
            border-top: 0;
            margin-bottom: 20px;
        }

        .tables-wrapper {
            margin-bottom: 20px;
            border: 2px solid #eee;
        }

        .product-pic-wrapper {
            vertical-align: middle;
        }

        .product-pic-wrapper .product-pic {
            width: 80px;
            height: 80px;
        }

        .product-name {
            padding-right: 10px;
        }

        .bar-code {
            display: block;
            width: 200px;
            height: 50px;
            margin-right: auto;
        }

        .order-summary {
            width: 50%;
            margin-right: auto;
        }

        .order-summary-row .summary-value {
            text-align: left;
        }

        footer {
            margin-bottom: 20px;
        }

        footer p {
            background-color: #f0f0f0;
            text-align: center;
            padding: 10px;
        }

    </style>
</head>

<body>
<header>
    <div class="wrapper">
        <table>
            <tr>
                <td class="website-info-wrapper text-center" colspan="2">
                    <div class="website-info text-center">
                        <img src="https://autowats.com/pdf/invoice-pdf/eitara-logo.png" width="200" height="200"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" >
                    <div class="invoice-info-wrapper text-center">
                        <p class="fw-bold text-sm-size text-center">فاتورة الطلب</p>
                        <p class="order-id dir-ltr fw-bold text-sm-size text-center">#{{$data['reference_id']}}</p>
                        <p class="order-date dir-ltr fw-bold text-sm-size text-center">{{Carbon\Carbon::parse($data['date']['date'])->format('Y-m-d H:i:s')}}</p>
                        <p class="order-date dir-ltr fw-bold text-sm-size text-center">طريقة الدفع: {{ $data['payment_method'] }}</p>
                        <div class="tax-num text-center">
                            @php

                                echo  Str::replace('<?xml version="1.0" standalone="no"?>', '', DNS1D::getBarcodeSVG($data['reference_id'], 'C39',2,50,'black', true))
                            @endphp
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</header>

<main>

    <div class="wrapper text-center">
        <div class="order-details text-center">
            <div class="tables-wrapper text-center">
                <table class="products-table text-center">
                    <thead>
                    <tr>
                        <td class="fw-bold text-sm-size text-center ">الصورة</td>
                        <td class="fw-bold text-sm-size text-center ">المنتج</td>
                        <td class="fw-bold text-sm-size text-center ">الرقم المخزني</td>
                        <td class="fw-bold text-sm-size text-center ">الكمية</td>
                        <td class="fw-bold text-sm-size text-center ">السعر</td>
                        <td class="fw-bold text-sm-size text-center ">المجموع</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data['items']) && is_array($data['items']) && count($items = $data['items']))
                        @foreach($items as $key => $item)
                            <tr>
                                <td>
                            <span class="product-pic-wrapper">
                                        <img class="product-pic" src="{{$item['product']['thumbnail']}}"
                                             alt="product" width="100" height="100">
                                    </span>
                                </td>
                                <td class="product-pic-and-name">

                                    <span class="product-name text-sm-size">{{$item['name']}}</span>
                                    <br />
                                    @foreach($item['options'] as $option)
                                        {{$option['name']}}: {{$option['value']['name']}}
                                    @endforeach
                                </td>
                                <td class="store-num text-sm-size">{{$item['sku']}}</td>
                                <td class="quantity text-sm-size">{{$item['quantity']}}</td>
                                <td class="price text-sm-size">  {{ round(($item['product']['price']['amount'] ?? 0), 2) }}</td>
                                <td class="total-price text-sm-size"> {{ round(($item['amounts']['total']['amount'] ?? 0), 2) }}  </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>

</body>

</html>
