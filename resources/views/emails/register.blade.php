<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Création de compte Administrateur</title>

</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .header {
        width: 25%;
    }
    .header img {
        width: 100%;
        object-fit: cover;
        object-position: center;
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

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/Library2.png') }}" alt="Logo">
        </div>
        <div class="content">
            <h1>Bienvenue sur notre plateforme</h1>
            <p>Bonjour <span>{{ $user->name }}</span>,</p>
            <p>Votre compte administrateur a été créé avec succès.</p>
            <p>
                Vos identifiants de connexion sont les suivants, vous pourrez modifier votre mot de passe une fois connecté :
                <ul>
                    <li><strong>Email :</strong>
                        <span> {{ $user->email }}</span>
                    </li>
                    <li><strong>Mot de passe :</strong>
                        <span> {{ $passwordNoCrypt }}</span>
                    </li>
                </ul>
            </p>

            <p>Vous pouvez vous connecter en cliquant sur le bouton ci-dessous.</p>
            <a href="{{ route('admin.auth.login.form') }}" class="button">Se connecter</a>

        </div>
        <div class="footer">
            <p>&copy; 2024 - Tous droits réservés</p>
        </div>
    </div>
</body>

