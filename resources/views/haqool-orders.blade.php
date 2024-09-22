<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Haqool Orders</title>
</head>
<body>

    <h1>
        date: {{$date->format('Y-m-d   H')}} <br />
        Orders: {{$orders}} <br />
        Order Items: {{$orderItems}} <br />
        Empty Invoices: {{$emptyInvoices}} <br />
         Jobs: {{$jobs}} <br />
        Failed Jobs: {{$failed_jobs}} <br />

    </h1>

    <script>
        setTimeout(function () {
            window.location.reload();
        }, 5000);
        document.title = "total:  {{$jobs}}"
    </script>

</body>
</html>
