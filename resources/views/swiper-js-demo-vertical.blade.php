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

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
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
    <div class="swiper-pagination"></div>
</div>

<!-- Swiper JS -->
<script src="{{asset('js/swiper.js')}}"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        direction: "vertical",
        loop: true,

        autoHeight: true,
    });
</script>
</body>

</html>
