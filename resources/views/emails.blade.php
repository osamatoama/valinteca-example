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
<form method="post">
    @csrf

    <input type="email" name="email" placeholder="email" required>
    <input type="text" name="password" placeholder="password" required>

    <input type="submit">
</form>

@foreach($emails as $email)
    <p>{{$email->username}}</p>
@endforeach

</body>
</html>
