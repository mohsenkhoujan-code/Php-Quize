<?php
include_once('Json-management.php');

if (!function_exists('ready')) {
    function ready()
    {
        global $url_key;
        return array(


            '\$ciphering' => getenv("AES-128-CTR"),

            '\$iv_length' => getenv(openssl_cipher_iv_length("AES-128-CBC")),

            '\$options' => getenv(0),

            '\$encryption_iv' => getenv('1234567891011121'),

            '\$encryption_key' => getenv($url_key."asdaerd24324342esdzx"),

            '\$decryption_iv' => getenv('1234567891011121'),

        );
    }
}

if (!function_exists('encrypt')) {
    function encrypt($string)
    {

        $data = ready();
        $encryption = openssl_encrypt(
            $string,
            $data['\$ciphering'],
            $data['\$encryption_key'],
            $data['\$options'],
            $data['\$encryption_iv']
        );
        return $encryption;
    }
}


if (!function_exists('decrypt')) {
    function decrypt($code)
    {
        $data = ready();
        $decryption = openssl_decrypt(
            $code,
            $data['\$ciphering'],
            $data['\$encryption_key'],
            $data['\$options'],
            $data['\$encryption_iv']
        );
        return $decryption;
    }
}
header("HTTP/1.0 404 Not Found");