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
@if($success)
<h1>{{$success}}</h1>
@endif
<form method="post">
    @csrf
    <input type="email" name="email" placeholder="الايميل" required>
    <input type="text" name="name" placeholder="الاسم" required>
    <br/>
    <br/>
    <input type="submit">
</form>
</body>
</html>
