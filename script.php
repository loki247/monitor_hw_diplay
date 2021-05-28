<?php
ini_set("allow_url_fopen", 1);

exec("C:\Windows\System32\mode.com COM3 BAUD=9600 PARITY=N data=8 stop=1 xon=off");
$fp = fopen("com3", "w");

if (!$fp) {
    echo "Not open";
} else {
    $url = "http://localhost:8085/data.json";
    $data = file_get_contents($url);
    $obj = json_decode($data, true);

    $nombre_cpu = $obj['Children'][0]['Children'][1]['Text'];
    $temp_cpu = "TEMP: " . $obj['Children'][0]['Children'][1]['Children'][1]['Children'][1]['Value'];
    $clock_c1 = "CORE 1: " . $obj['Children'][0]['Children'][1]['Children'][0]['Children'][1]['Value'];
    $clock_c2 = "CORE 2: " . $obj['Children'][0]['Children'][1]['Children'][0]['Children'][2]['Value'];
    $clock_c3 = "CORE 3: " . $obj['Children'][0]['Children'][1]['Children'][0]['Children'][3]['Value'];
    $clock_c4 = "CORE 4: " . $obj['Children'][0]['Children'][1]['Children'][0]['Children'][4]['Value'];
    $clocks_cpu = $clock_c1 . "          " . $clock_c2 . "          " . $clock_c3 . "          " . $clock_c4;
    $carga_cpu = "LOAD: " . $obj['Children'][0]['Children'][1]['Children'][2]['Children'][0]['Value'];


    $nombre_gpu = str_replace("NVIDIA NVIDIA", "NVIDIA", $obj['Children'][0]['Children'][3]['Text']);
    $temp_gpu = "TEMP: " . $obj['Children'][0]['Children'][3]['Children'][1]['Children'][0]['Value'];
    $carga_gpu = "LOAD: " . $obj['Children'][0]['Children'][3]['Children'][2]['Children'][0]['Value'];

    $uso_ram = "RAM: " . str_replace("GB", "", $obj['Children'][0]['Children'][2]['Children'][1]['Children'][0]['Value']) . "/ 16 GB";

    $texto_final = strtoupper($nombre_cpu . "          " . $temp_cpu . "          " . $clocks_cpu . "          " . $carga_cpu . "          " . $nombre_gpu . "          " . $temp_gpu . "          " . $carga_gpu . "          " . $uso_ram);
        
    sleep(10);
    fwrite($fp, $texto_final);
    //$buff = fread($fp, 10);
    fclose($fp);
}