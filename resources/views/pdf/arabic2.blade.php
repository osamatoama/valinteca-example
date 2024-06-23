<!doctype html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket 1111111111111</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Tajawal', sans-serif;
        }

        .ticket-text {
            position: fixed;
            top: 240px;
            right: 25px;
            rotate: 90;
            text-align: center;

            color: white;

        }

        .ticket-number {
            position: fixed;
            top: 40px;
            right: 25px;
            rotate: 90;
            text-align: center;

            color: white;
        }

        .event-title {
            position: fixed;
            top: 40px;
            right: 100px;
            text-align: center;
            z-index: 100;
        }

        .event-date {
            position: fixed;
            top: 250px;
            right: 100px;
            padding: 12px 32px;
            background-color: #f5f0ea;
            font-weight: 700;
            text-align: center;
            word-spacing: 4px;
            width: 160px;
        }

        .event-time {
            position: fixed;
            top: 40px;
            right: 400px;
            text-align: center;
            z-index: 100;
        }

        .ticket-price {
            position: fixed;
            top: 40px;
            right: 600px;
            text-align: center;
            z-index: 100;
        }
    </style>
</head>

<body>

<img src="{{$base64}}"/>
<h4 class="ticket-text">رقم التذكرة:</h4>
<h4 class="ticket-number">123456789123</h4>

<h1 class="event-title">
    حفلة العام
    المميزة
</h1>

<h2 class="event-date">
    14 اكتوبر, 2025
</h2>

<div class="event-time">
    <p>الوقت:</p>
    <p>4:00 مساءاً</p>
</div>

<div class="ticket-price">
    <p>السعر:</p>
    <p>7000 $</p>
</div>

<div class="info-item">
    <span>العنوان:</span>
    <small>ستوديو اّدم,<br>
        شارع المدينة , جدة , السعودية</small>
</div>


{{--<img src="./ticket/images/logo.png" width="100" height="100" alt="valinteca-logo">--}}
{{----}}
{{--<img src="./ticket/images/qr-code.png" width="100" height="100" alt="qr-code">--}}
{{--<img src="./ticket/images/barcode.jpg" width="100" height="100" alt="qr-code">--}}

<h3 class="ticket-type">
    مميز
</h3>
</body>

</html>
