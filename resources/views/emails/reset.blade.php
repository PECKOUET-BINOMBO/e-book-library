<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réinitialisation de votre mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #3743DB;
            color: #ffffff;
        }

        .header img {
            display: block;
            margin: 0 auto;
        }

        .content {
            padding: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3743DB;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        p span {
            color: #3743DB;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- image logo--}}
        <img src="{{ asset('img/Library3.png') }}" alt="Logo" width="100">
        <div class="header">
            <h2>Réinitialisation de votre mot de passe</h2>
        </div>
        <div class="content">
            <p>Bonjour {{$user->name}} ,</p>
            <p>Nous avons reçu une demande de réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous
                pour réinitialiser votre mot de passe :</p>
            <p><a href="{{route('reset_form', $token)}}" class="button">Réinitialiser mon mot de passe</a></p>
            <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet email.</p>
            <p>Merci,</p>
            <p>L'équipe <span>{{config('app.name')}}</span></p>
        </div>
        <div class="footer">
            <p>&copy; 2024 {{config('app.name')}}. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
