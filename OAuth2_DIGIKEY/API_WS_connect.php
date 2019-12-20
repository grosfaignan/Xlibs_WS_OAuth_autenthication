<!--tutoriel OAuth : https://www.youtube.com/watch?v=I5tFlK5PPjc -->
<!-- page qui gere la demande de connexion et l'utilisation des token entre l'api distante et le sit local-->

<?php

require __DIR__.'\vendor\autoload.php';
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X_UA-Compatible" content="id=edge">
    <title>Essais OAuth</title>
</head>
<body>
    <h1> Se Connecter</h1>
    <P>

        <a href="https://sandbox-api.digikey.com/v1/oauth2/authorize?response_type=code&client_id=<?=DIGIKEY_ID?>&redirect_uri=<?= urlencode(curntFold.connPage)?>">Se connecter via DIGIKEY</a>
    </p>

</body>
</html>


<?php
use GuzzleHttp\Client;

$codForTokn=$_GET['code'];
$URI=curntFold.connPage;
$DPN="493-3775-2-ND";


$client = new Client([
    // You can set any number of default request options.
    'timeout'  => 10.0,
    //verification du certificat (téléchargé préalablement sur curl.haxx.se) certificat concernant curl
    'verify'=>__DIR__.'/cacert.pem'
]);

try
{
    $adresse='https://sandbox-api.digikey.com/v1/oauth2/token';
    $response = $client->request('POST',$adresse,
    [
        'form_params' =>
        [
            'code'=>$codForTokn,
            'client_id'=> DIGIKEY_ID,
            'client_secret' =>DIGIKEY_SECRET,
            'redirect_uri' => $URI,
            'grant_type' => 'authorization_code'
        ]
    ]);

    $accessToken = json_decode($response->getBody())->access_token;
    $refreshToken = json_decode($response->getBody())->refresh_token;

    dump($accessToken);
    echo("<br/>");
    dump($refreshToken);
    echo("<br/>");
    dump($response);

    $response = $client->request('GET', 'https://sandbox-api.digikey.com/Search/v3/Products/'.$DPN,
    [
        'headers' =>
        [
            'X-DIGIKEY-Client-Id'=> DIGIKEY_ID,
            'Authorization'=>'Bearer '.$accessToken,
            'X-DIGIKEY-Locale-Site'=> 'FR',
            'X-DIGIKEY-Locale-Language'=> 'fr',
            'X-DIGIKEY-Locale-Currency'=> 'EUR',
            'X-DIGIKEY-Locale-ShipToCountry'=> 'fr',
            'X-DIGIKEY-Customer-Id'=> 0
        ]
    ]);
    $response = json_decode($response->getBody());
    dump($response);

   /* if($response->email_verified === true)
    {
        session_start();
        $_SESSION['email'] = $response->email;
        header('Location: http://localhost/OAuth2_TEST/secret.php');
        exit();
    }*/

}
catch(\GuzzleHttp\Exception\ClientException $exception)
{
    dump($exception->getMessage());
}
?>
