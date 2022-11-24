<html>
<head>
    <title>Simple 404 Error Page Design</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:700" rel="stylesheet">
    <style>
        h1{
            font-size:80px;
            font-weight:800;
            text-align:center;
            font-family: 'Roboto', sans-serif;
        }
        h2
        {
            font-size:25px;
            text-align:center;
            font-family: 'Roboto', sans-serif;
            margin-top:-40px;
        }
        p{
            text-align:center;
            font-family: 'Roboto', sans-serif;
            font-size:12px;
        }

        .container
        {
            width:300px;
            margin: 0 auto;
            margin-top:15%;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>{{ $msg }}</h2>
</div>
</body>
</html>
