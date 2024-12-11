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
            width: 500px;
            background: #fff;
            border: 1px solid #f0f2f8;
            margin: 0 auto;
        }

        .card-header {
            max-width: 100%;
            height: 64px;
            border-bottom: 3px solid #f0f2f8;
        }

        .card-header>img {
            width: 139px;
            height: 24px;
            position: relative;
            top: 18px;
        }

        .card-content {
            width: 100%;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .card-footer {
            width: 100%;
            height: 44px;
            background: #f0f2f8;
        }

        .text {
            color: #333a44;
            display: block;
            font-size: 14px;
            line-height: 23px;
            height: 100%;
        }

        .text>p {
            margin-bottom: 32px;
        }

        .text-title {
            font-size: 22px;
            line-height: 24px;
            font-weight: 700;
        }

        .pin {
            color: #5b1979;
            font-size: 22px;
            line-height: 24px;
            font-weight: 500;
        }

        .by {
            color: #7a869a;
            font-size: 10px;
            line-height: 45px;
            margin: 0 auto;
            text-align: center;
            height: 100%;
        }

        .by>img {
            width: 73px;
            height: 10px;
            margin-left: 4px;
            position: relative;
            top: 0;
        }

        .btn {
            margin: 0 auto;
            font-size: 16px;
            line-height: 45px;
            font-weight: 700;
            background-color: #5b1979;
            color: #fff;
            white-space: nowrap;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            width: 161px;
            display: block;
            height: 48px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header px-16">
            <img
                src="https://homolog-accounts.cosmos.app.br/logo-cosmos.png"
                alt="{{config('app.name')}}"
                style="margin-top: 20px" />
        </div>
        <div class="card-content" style="height: 442px">
            <div class="text">
                <p class="text-title px-16">Configuração de primeiro acesso</p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    Olá, {{$username}},
                </p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    Você está iniciando o processo para realizar seu primeiro acesso ao
                    Cosmos.
                </p>
                <p style="font-size: 22px; line-height: 24px" class="px-16 pin">
                    PIN: <span style="letter-spacing: 6px;">{{$pin}}</span>
                </p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    Clique no botão abaixo e insira o PIN informado, para definir a nova
                    senha.
                </p>
                <p>
                    <a href="{{$url}}" style="color: #fff;" class="btn px-16">Clique aqui</a>
                </p>
                <p style="font-size: 14px; line-height: 23px" class="px-16">
                    O PIN e o link do botão possuem validade de 1 hora. Após esse
                    período será necessário solicitar a recuperação de senha novamente.
                </p>
            </div>
        </div>
        <div class="card-footer">
            <div class="by px-16">
                Desenvolvido por
                <img
                    alt="img-footer"
                    src="https://homolog-accounts.cosmos.app.br/image.png" />
            </div>
        </div>
    </div>
</body>

</html>
