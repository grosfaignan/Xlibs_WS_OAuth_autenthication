<!--tutoriel OAuth : https://www.youtube.com/watch?v=I5tFlK5PPjc -->
<!-- page d'accueuil avec le bouton de connection-->

<?php 
require('config.php')
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
    <p>
        <!--<a href="https://accounts.google.com/o/oauth2/v2/auth?scope=email&access_type=online&redirect_uri=<?= urlencode('http://localhost/OAuth2_TEST/connect.php') ?>&response_type=code&client_id=<?=GOOGLE_ID ?>">Se connecter via Google</a>-->
    </p>
    <P>

        <a href="https://sandbox-api.digikey.com/v1/oauth2/authorize?response_type=code&client_id=<?=DIGIKEY_ID?>&redirect_uri=<?= urlencode(curntFold.connPage)?>">Se connecter via DIGIKEY</a>
    </p>

</body>
</html>
