<?php 


$api_secret = "634c4fc187238c4b3e3f037a08c3ec0efcd3ca450bbc27a6188b5db4e477c74d";




//CHECK IF TOKEN RECEBIDO EXISTS AND IS VALID
if(!isset($_GET['jwt'])){
    header("HTTP/1.0 401 Unauthorized");
    print "Sorry - you need get the token access!\n";
    exit;
}else{ 


    $token = $_GET['jwt'];

    
    //CHECK IF se token RECEBIDO é um JWT valido COM REGEX xxx.xxx.xxx
    if(!preg_match("/[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.([a-zA-Z0-9\-_]+)$/",$token)){

        header("HTTP/1.0 401 Unauthorized");
        print "Sorry - token is invalid!\n";
        exit;

    }else{ //SUCESSO -> TOKEN FOI PASSADO E É UM JWT FOMATO VALIDO


                //Chamamos a funcao para criar um NOVO JWT e verificar a autenticidade
                $verify = decodificar_jwt($token,$api_secret);

                    //Verificamos se o JWT informado é igual ao GERADO por nosso Script
                    if($token != $verify){

                        header("HTTP/1.0 401 Unauthorized");
                        echo "Hacked - you need get the token access!";
                        echo "<br><br>";
                        echo "JWT enviado:<br>".$token;
                        echo "<br><br>";
                        $hacked = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))),true);
                        print_r($hacked);
                        exit;
                    }else{


                        echo "AUTENTICADO - FAZER LIBERAR PESQUISA POR NOME";



                        

                    }


    }
}







//MENSAGEM BOAS VINDAS
$decode_jwt = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $verify)[1]))),true);
echo "Welcome back: ".$decode_jwt["uname"];
echo "<br><br>";
print_r($decode_jwt);
echo "<br><br>";
echo "<a href='api.php'>voltar</a>";
echo "<br><br>";












    function decodificar_jwt($token,$api_secret){


        /**
         *    
         *    Step by Step: Vamos Gerar um novo JWT (com nossa assinatura) para verificar se BATE com o JWT fornecido
         * 
         *    Step 1 -> Decodificamos o TOKEN recebido, e extraimos a parte PAYLOAD dele (atributos recebidos)
         *    Step 2 -> Geramos um novo TOKEN JWT com nossa API_KEY e atributos recebidos
         *    Step 3 -> Retornamos o TOKEN JWT gerado, e verificamos se o JWT recebido é IGUAL ao GERADO
         * 
         * 
         */



        //Step 1 -> Decodificar PlayLoad 
        //Deve retornar um array exemplo  ->   array(3) ["user_id"]=> int(1) ["nome_empresa"]=> string(19) "Google Ltd" ["created"]=> string(10) "26/04/2022"
        $payload_decodificada = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))),true);
        //var_dump($payload_decodificada);
        

        //Step 2 -> Geramos um novo JWT com os valores da variavel Payload recebidos, mas com nossa assinatura
        //Com isso verificamos se nao modificaram nada na PLAYLOAD



                    // Create token header as a JSON string
                    //$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
                    // Create the token header
                    $header = json_encode([
                        'typ' => 'JWT',
                        'alg' => 'HS256'
                    ]);


                                // Create token payload as a JSON string 
                                //(Utilizamos o array da PAYLOAD decodificada, campos passados no JSON)
                                $payload = json_encode( $payload_decodificada );
                                //var_dump($payload_decodificada);

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

                                //Step 3 -> Retornamos o TOKEN Gerado
                                return $jwt;

    }










    //GET INFOS
        function get_http(){

            //header("Authorization: Bearer $token");
            //Receiver HTTP header like that
            //$headers = apache_request_headers();//assuming that we are using apache as webserver
            //$token = $headers['token'];

            foreach (getallheaders() as $name => $value) {
                global $token, $nome, $cpf, $rg, $telefone; 
                if($name=="token") { $token = $value; }
                if($name=="nome") { $nome = $value; }
                if($name=="cpf") { $cpf = $value; }
                if($name=="rg") { $rg = $value; };
                if($telefone=="telefone") { $telefone = $value; };
                //echo "$name: $value\n";
            }
    }




















    // Get header Authorization - https://stackoverflow.com/questions/40582161/how-to-properly-use-bearer-tokens

function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

// get access token from header
 
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
            //return $headers;
        }
    }
    return null;
}


?>