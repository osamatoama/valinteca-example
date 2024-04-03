<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Info</title>
    <style>
        .container  {
            display: flex;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

    </style>
</head>
<body>


<div class="container">
    <h1>emails: {{$emails}}</h1>
    <h1>all codes: {{$allCodes}}</h1>
    <h1>redeemed Codes By Bot: {{$redeemedCodes}}</h1>
    <h1>income: {{$redeemedCodes / 2}} SAR</h1>
</div>

<script>
    setTimeout(function () {
       window.location.reload()
    }, 15000);
</script>
</body>
</html>
