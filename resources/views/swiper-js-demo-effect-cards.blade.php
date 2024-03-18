<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Swiper demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="{{asset('css/swiper.css')}}" />

    <!-- Demo styles -->
    <style>
        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        body {
            background: #fff;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper {
            width: 400px;
            height: 400px;
        }

        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
        }

        .swiper-slide:nth-child(1n) {
            background-color: rgb(206, 17, 17);
        }

        .swiper-slide:nth-child(2n) {
            background-color: rgb(0, 140, 255);
        }

        .swiper-slide:nth-child(3n) {
            background-color: rgb(10, 184, 111);
        }

        .swiper-slide:nth-child(4n) {
            background-color: rgb(211, 122, 7);
        }

        .swiper-slide:nth-child(5n) {
            background-color: rgb(118, 163, 12);
        }

        .swiper-slide:nth-child(6n) {
            background-color: rgb(180, 10, 47);
        }

        .swiper-slide:nth-child(7n) {
            background-color: rgb(35, 99, 19);
        }

        .swiper-slide:nth-child(8n) {
            background-color: rgb(0, 68, 255);
        }

        .swiper-slide:nth-child(9n) {
            background-color: rgb(218, 12, 218);
        }

        .swiper-slide:nth-child(10n) {
            background-color: rgb(54, 94, 77);
        }

        img {
            object-fit: contain;
            max-width: 100%;
            width: 100%;
        }
    </style>
</head>

<body>
<!-- Swiper -->

<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        @foreach($products as $product)
            <div class="swiper-slide">
                <img src="{{$product->image}}" />
            </div>
        @endforeach

    </div>
</div>

<!-- Swiper JS -->
<script src="{{asset('js/swiper.js')}}"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "cards",
        grabCursor: true,
    });
</script>
</body>

</html>
