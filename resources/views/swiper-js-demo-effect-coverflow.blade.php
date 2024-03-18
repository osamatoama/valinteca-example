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
            height: 100vh;
        }

        .swiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 400px;
            height: 400px;
        }

        .swiper-slide img {
            display: block;
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
    <div class="swiper-pagination"></div>
</div>

<!-- Swiper JS -->
<script src="{{asset('js/swiper.js')}}"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
    });
</script>
</body>

</html>
