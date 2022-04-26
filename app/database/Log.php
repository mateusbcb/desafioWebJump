<?php

    namespace App\Database;

    class Log 
    {
        public function log($codigo, $msg, $tipo)
        {
            date_default_timezone_set("America/Sao_Paulo");
            $data = date('d-m-Y h:i:s', time());

            $arquivo = __DIR__.'/../Logs/Logs_'.$tipo.'.txt';

            $referencia = $_SERVER['HTTP_REFERER'];
            $host = $_SERVER['HTTP_HOST'];

            $log = "$data - $codigo - $msg - $tipo - $host - $referencia ".PHP_EOL;

            $fo = fopen($arquivo, 'a+');

            fwrite($fo, $log);

            fclose($fo);
        }
    }

?>