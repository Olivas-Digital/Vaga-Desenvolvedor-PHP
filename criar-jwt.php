<?php



    //START AUTENTICATION - VERIFY IF USER WAS INSERTED
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header("WWW-Authenticate: Basic realm=\"Private Area\"");
        header("HTTP/1.0 401 Unauthorized");
        print "Sorry - you need valid credentials to be granted access!\n";
        exit;
    } else { //USER WAS INSERTED - VERIFY LOGIN DETAILS
        if (($_SERVER['PHP_AUTH_USER'] == 'gustavo') && ($_SERVER['PHP_AUTH_PW'] == '12345')) {
            header('HTTP/1.0 200 OK'); //header('Content-Type: application/json');
            $generate_jwt = criar_jwt();
            print "Welcome to the private area!<br><br><br>";
            print $generate_jwt;
            echo "<br><br><br>";

            //Decodificar JWT e retornar em formato ARRAY
            $decode_jwt = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $generate_jwt)[1]))),true);
            echo "Nome da empresa: ".$decode_jwt["uname"];
            echo "<br><br><br>";
            var_dump($decode_jwt);

        } else {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            print "Sorry - you need valid credentials to be granted access!\n";
            exit;
        }
    }



    function criar_jwt(){
        
        

         $api_secret = "634c4fc187238c4b3e3f037a08c3ec0efcd3ca450bbc27a6188b5db4e477c74d";




        // Create token header as a JSON string
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);

        $payload = json_encode([
            'sub' => 123, //ID do usuario tbm referenciado como user_id (opcional)
            'uname' => 'Google Empresa', //Username eu que fiz (opcional)
            'iss' => 'your.domain.name', // Issuer dominio de quem emitiu o token (opcional)
            'iat' => time(), // Issued at: time when the token was generated (opcional)
            'nbf' => time(), // Not before (OPCIONAL) a timestamp of when the token should start being considered valid. Should be equal to or greater than iat.
            'exp' => time()+ 60 * 60 * 8, // Expire (unico parametro que nao é opcional, segundo o rfc, mas pode ser)
            'key' => strtoupper(uniqid()) //(opcional)
        ]);
        

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $api_secret, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;

    }




?>

<br><br>
<a href="verificar-jwt.php?jwt=<?php header("Authorization: Bearer $generate_jwt"); echo $generate_jwt; ?>">Logado</a>









