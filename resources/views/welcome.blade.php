<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IPersonal - API</title>
    <link rel="icon" type="image/ico" href="https://ipersonal.onrender.com/icons/favicon.ico" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: Roboto, sans-serif;
        }

        main {
            height: 100vh;
            width: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #0f0a38;
            gap: 10px;
        }

        .logo {
            height: 50px;
        }

        hr {
            border: 1px dashed #ececec;
            width: 500px;
        }

        .btn {
            width: 150px;
            background-color: #0f0a38;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 100px;
            text-decoration: none;
            font-size: 20px;
        }

        .content-flex {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            color: #0f0a38;
        }
    </style>
</head>

<body class="font-sans">
    <main>
        <div class="content-flex">
            <b>API - </b>
            <img class="logo" src="{{ asset('img/logo.png') }}" alt="logo" />

        </div>
        <div class="content-flex">
            <a href="/docs" class="btn">Docs</a>
        </div>
    </main>
</body>

</html>
