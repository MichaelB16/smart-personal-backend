<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dieta - PDF</title>
    <!-- Fonts -->
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }

        .d-flex {
            display: flex;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .flex-column {
            flex-direction: column;
        }

        .full-width {
            width: 100%;
        }

        .w-130 {
            width: 130px;
        }

        .w-550 {
            width: 550px;
        }

        .h-100 {
            height: 100px;
        }

        .bold {
            font-weight: bold;
        }


        .text-left {
            text-align: left;
        }

        .size-24 {
            font-size: 24px;
        }

        .size-20 {
            font-size: 20px;
        }

        .size-13 {
            font-size: 13px;
        }

        .row {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        .gap {
            gap: 6px;
        }

        .justify-center {
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: separate;
            text-align: left;
            overflow: hidden;

            td,
            th {
                border: 1px solid #ECF0F1;
                padding: 10px;
            }

            .bg-blue {
                background-color: #9a9a9a;
            }

            .text-white {
                color: white;
            }

            tr:nth-of-type(even) td {
                background-color: #eaeaeae6;
            }
        }
    </style>
</head>


<body class="font-sans">
    <main>
        <table>
            <thead>
                <tr>
                    @if ($logo)
                    <th class="w-130 h-100">
                        <img class="w-130 h-100" src="{{$logo}}" alt="logo" />
                    </th>
                    @endif
                    <th colspan="3">
                        <div class="d-flex gap flex-column justify-center full-width">
                            <div class="row justify-center">
                                <b class="size-24">Ficha de Dieta</b>
                            </div>
                            <div class="row justify-center">
                                <b class="text-capitalize size-20">
                                    {{$student}}
                                </b>
                            </div>
                            <div class="row justify-center">
                                <b class="text-capitalize size-20">
                                    Personal trainer: {{$coach}}
                                </b>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr class="bg-blue text-white">
                    <th class="bold text-left w-130">Dia</th>
                    <th class="bold text-left">Refeições</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listDiet as $diet)
                <tr>
                    <td class="text-left size-14">{{$diet->day}}</td>
                    <td>
                        <div class="d-flex w-550 flex-column gap">
                            @foreach ($diet->meals as $meals)
                            <div class="row full-width">
                                <b class="size-13">
                                    {{$meals->label}}:
                                </b>
                                <small class="size-13">{{$meals->description}}</i></small>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
