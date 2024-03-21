<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Info</title>
</head>
<body>


<h1>players: {{$players}}</h1>
<h1>all codes: {{$allCodes}}</h1>
<h1>redeemed Codes: {{$redeemedCodes}}</h1>
<h1>emails: {{$emails}}</h1>

<script>
    setTimeout(function () {
        window.location.reload()
    }, 10000);
</script>
</body>
</html>
