<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> abaya-statistics </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>


<h1 class="text-center">
    احصائيات عامة
</h1>

<table class="table">
    <thead>
    <tr>
        <th scope="col">نجمة وحدة</th>
        <th scope="col">نجمتين</th>
        <th scope="col">ثلاث نجمات</th>
        <th scope="col">اربع  نجمات</th>
        <th scope="col">خمس  نجمات</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <th>{{$one_star}}</th>
        <th>{{$two_stars}}</th>
        <th>{{$three_stars}}</th>
        <th>{{$four_stars}}</th>
        <th>{{$five_stars}}</th>
    </tr>

    </tbody>
</table>

<hr />
</body>
</html>
