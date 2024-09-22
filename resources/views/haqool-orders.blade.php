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
        First Date: {{$firstDate->format('Y-m-d   H')}} <br /> <hr />
        Last Date: {{$lastDate->format('Y-m-d   H')}} <br /> <hr />
        Orders: {{$orders}} <br /> <hr />
        Order Items: {{$orderItems}} <br /> <hr />
        Empty Invoices: {{$emptyInvoices}} <br /> <hr />
        Default Jobs: {{$defaultJobs}} <br /> <hr />
        Pull Order Jobs: {{$pullOrderJobs}} <br /> <hr />
        Failed Jobs: {{$failed_jobs}} <br /> <hr />

    </h1>

    <script>
        setTimeout(function () {
            window.location.reload();
        }, 5000);
        document.title = "total:  {{$defaultJobs + $pullOrderJobs }}"
    </script>

</body>
</html>
