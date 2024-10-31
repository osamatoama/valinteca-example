<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<body>

<div class="container">
    <table border="1">
        <thead>
        <tr>
            <th>name</th>
            <th>face_value</th>
            <th>product_id</th>
            <th>product_type </th>
            <th>price</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product['name']}}</td>
                <td>{{$product['face_value']}}</td>
                <td>{{$product['product_id']}}</td>
                <td>{{$product['product_type']}}</td>
                <td>{{$product['sales_price']}} {{$product['sales_currency']}} </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
