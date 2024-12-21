<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");

        * {
            margin: 0px;
            padding: 0px;
            font-family: "Roboto", sans-serif;
        }

        .px-16 {
            padding-left: 24px;
            padding-right: 24px;
        }

        .card {
            width: 460px;
            background: #fff;
            border: 1px solid #e4e2e2;
            margin: 0 auto;
            border-radius: 4px;
        }

        .card-header {
            max-width: 100%;
            height: 64px;
            border-bottom: 1px solid #e4e2e2;
        }

        .card-header>img {
            height: 35px;
            margin-top: 12px;
            margin-left: -12px;
        }

        .card-content {
            width: 100%;
            padding-top: 16px;
            padding-bottom: 16px;
        }

        .text {
            color: #0f0a38;
            display: block;
            font-size: 14px;
            line-height: 23px;
            height: 100%;
        }

        .text>p {
            margin-bottom: 16px;
        }

        .text-title {
            font-size: 22px;
            line-height: 24px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header px-16">
            <img
                src="{{ asset('img/logo.png') }}"
                alt="{{config('app.name')}}" />
        </div>
        <div class="card-content" style="height: 500px">
            <div class="text">
                <p class="text-title px-16">Bem vindo ao {{config('app.name')}} </p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    Olá, {{$data['username']}}.
                </p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    Bem-vindo à nossa plataforma! Aqui, você poderá organizar e gerenciar todas as atividades do seu dia a dia como personal trainer de forma simples e eficiente.
                </p>
                <div class="px-16" style="height: 300px;">
                    <b>Rumo ao nosso objetivo, com foco e determinação!</b>
                    <img
                        style="height: 100%; margin-top:8px; width: 100%;"
                        alt=banner
                        src="{{ asset('img/banner-welcome.png') }}" />
                </div>
            </div>
        </div>
    </div>
</body>

</html>
