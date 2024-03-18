<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<a href="{{route('public_update')}}">تحديث كلي </a>
<h1>انشاء مجموعة اسعار جديدة </h1>
<form method="post" action="{{route('create-group-prices')}}">
    @csrf
    <input type="text" placeholder="group name" name="name">
    <input type="submit">
</form>
<hr/>
<hr/>
@foreach($groups as $group)

    <h1 style="text-align: center">{{$group->name}}</h1>
    <table border="1">
        <thead>
        <tr>
            <th>name</th>
            <th>url</th>
            <th>price before</th>
            <th>price after</th>
        </tr>
        </thead>
        <tbody>

        @foreach($group->products as $product)
            <tr>
                <td> {{$product->name}}</td>
                <td><a href="{{$product->url}}" target="_blank">{{$product->url}}</a></td>
                <td> {{$product->price_before}}</td>
                <td> {{$product->price_after}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <br/>
    <form method="post" action="{{route('create-price-product')}}">
        @csrf
        <input type="text" placeholder="product name" name="name" required>
        <input type="url" placeholder="product url" name="url" required>
        <input type="hidden" placeholder="product url" name="group_id" value="{{$group->id}}">
        <input type="submit"  value="add">
    </form>
@endforeach
</body>
</html>
