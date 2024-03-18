<!doctype html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Dastnevis', sans-serif;
        }

        h1 {
            font-size: 60px;
            z-index: 500;
            position: fixed;
            top: 47%;
            text-align: center;
            width: 100%;
            color: #076aa5
        }

    </style>
</head>

<body>

    <img src="{{$base64}}" />
    <h1> {{$name}}</h1>
</body>

</html>
