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

        .px-24 {
            padding-left: 24px;
            padding-right: 24px;
        }

        .px-12 {
            padding-left: 12px;
            padding-right: 12px;
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
            margin-top: 14px;
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

        .btn {
            margin: 0 auto;
            font-size: 16px;
            line-height: 45px;
            font-weight: 700;
            background-color: #0f0a38;
            color: #fff;
            white-space: nowrap;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            width: 161px;
            display: block;
            height: 48px;
            margin-top: 0.6em;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header px-12">
            <img
                src="{{ asset('img/logo.png') }}"
                alt="{{config('app.name')}}" />
        </div>
        <div class="card-content" style="height: 540px">
            <div class="text">
                <p class="text-title px-24">Esqueceu a senha? </p>
                <p style="font-size: 14px; line-height: 23px" class="px-24">
                    Olá, <b>{{$username}}</b>.
                </p>
                <p style="font-size: 14px; line-height: 23px" class="px-24">
                    Recebemos seu pedido para redefinir a senha de acesso à sua conta. Não se preocupe, é simples e rápido!
                </p>
                <div class="px-24" style="height: 300px;">
                    <img
                        style="height: 100%; margin-top:8px; width: 100%;"
                        alt=banner
                        src="{{ asset('img/banner-forgot.png') }}" />
                </div>
                <div class="px-24" style="margin-top: 1em;">
                    <i style="font-size: 14px; line-height: 23px">
                        Clique no botão abaixo para redefinir sua senha com segurança:
                    </i>
                    <a href="{{$url}}" style="color:#fff;" class="btn">
                        Redefinir
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
