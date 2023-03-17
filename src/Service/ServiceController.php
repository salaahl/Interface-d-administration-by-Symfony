<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends AbstractController
{
    public function mailConfirmation($name, $mail, $password): Response
    {
        $mailConfirmation =
            "
            <html lang='fr'>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width'>
                    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>
                    
                    <style>
                    body
                    {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    table
                    {
                        width: 50vw;
                        border: 1rem solid highlight;
                        background-color: lightgray;
                    }
                    th
                    {
                        background-color: gray;
                    }
                    td
                    {
                        border: 1px solid gray;
                    }
                    </style>
                
                </head>
                <body>
                    <table>
                    <thead>
                        <tr>
                        <th colspan='2'>Bienvenue sur Fitness P !</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='2'>
                                Bonjour " . htmlspecialchars($name) . ",<br>
                                Voici vos identifiants de connexion. Notez que le mot de passe n'est valable que pour la première connexion. 
                                Il devra être changé par la suite.
                            </td>
                        </tr>
                        <tr>
                            <td>mail :</td>
                            <td>" . htmlspecialchars($mail) . "</td>
                        </tr>
                        <tr>
                            <td>mot de passe :</td>
                            <td>" . htmlspecialchars($password) . "</td>
                        </tr>
                        <tr>
                            <td colspan='2'><a href='https://ecf-salaha.herokuapp.com/login.html' class='btn btn-primary'>Se connecter</a></td>
                        </tr>
                    </tbody>
                    </table>
                    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
                </body>
            </html>";

            return new Response($mailConfirmation);
    }
}