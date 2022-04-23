<?php

////FAZER O CRUD NO OUTRO PHP
//if($_SERVER['REQUEST_METHOD'] == 'PUT') { echo "put"; }
//if($_SERVER['REQUEST_METHOD'] == 'DELETE') { echo "delete"; }


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
            echo "Nome da empresa: ".$decode_jwt["nome_empresa"];
            echo "<br><br><br>";
            var_dump($decode_jwt);

            //Decodificar JWT e retornar em formato OBJETO - exemplo: object(stdClass)#1 (3) { ["user_id"]=> int(12345678) }
            //$decode_jwt = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $generate_jwt)[1]))));
            
            //Decodificar JWT e retornar em formato JSON - exemplo: string(80) "{"user_id":12345678}"
            //$decode_jwt = base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $generate_jwt)[1])));

        } else {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            print "Sorry - you need valid credentials to be granted access!\n";
            exit;
        }
    }



    //Criar seu proprio token jwt
    //Referencia -> https://dev.to/robdwaller/how-to-create-a-json-web-token-using-php-3gml )
    //Decodificar o jwt aqui -> https://jwt.io/
    function criar_jwt(){
        
        //Minha chave secreta para gerar o JWT -> De preferencia uma string forte
        //$api_secret = "!abC123@"; 
        $api_secret = "V2JHUzZsekZxdnZTUThBTGJPeGF0";

        // Create token header as a JSON string
        //$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // Create the token header
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);

        // Create token payload as a JSON string
        //$payload = json_encode(['user_id' => 12345,'nome_empresa' => 'SOMMA Investimentos','created'=>date('d/m/Y')]);
        $payload = json_encode([
            'user_id' => 12345,
            'nome_empresa' => 'SOMMA Investimentos',
            'created' => date('d/m/Y')
        ]);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        //$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, '!abC123@', true);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $api_secret, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;

    }




?>