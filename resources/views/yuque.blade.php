<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<body>

<div class="container">
    <h1>Yuque Products Count: {{ $products->count() }}</h1>
    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Remote ID</th>
            <th>Name</th>
            <th>value </th>
            <th>price</th>
            <th>type</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->remote_id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->face_value}}</td>
                <td>{{$product->sales_price}}  {{$product->sales_currency}} </td>
                <td>
                    {{ ((int)$product->product_type) === 4 ? 'Top Up' : 'Gift Card'}}
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
