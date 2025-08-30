<?php

$questions = array();
$json_name = "../API/test_json.json";
$json_dir = "../API/";
$url_key = getenv("AYChgWGB4QABgKG");


if(!function_exists('JsonIntoQ'))
{
    function JsonIntoQ($path)
    {
        global $json_name;
        $jc = file_get_contents($path);
        if (empty($jc)) {
            return -1;
        } else {
            $jc = json_decode($jc, true);
        }
        return $jc;
    }
}


if(!function_exists('QintoJson'))
{
    function QintoJson($qs ,$path, $ke = true)
    {
        global $json_name;
        $jc = file_get_contents($path);
        if (!(empty($jc)) && $ke) {
            $jc = json_decode($jc, true);
            foreach ($jc as $i) {
                array_push($qs, $i);
            }
        }
        $jsonstr = json_encode($qs);
        $jfile = fopen($path, 'w');
        fwrite($jfile, $jsonstr);
        fclose($jfile);
    }
}


if(!function_exists('json_file_format'))
{
    function json_file_format($path)
    {
        return $path.'.json';
    }
}

header("HTTP/1.0 404 Not Found");