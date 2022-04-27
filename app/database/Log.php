<?php

    namespace App\Database;

    class Log 
    {
        public function log($codigo, $msg, $tipo)
        {
            date_default_timezone_set("America/Sao_Paulo");
            $data = date('d-m-Y h:i:s', time());

            $dataArquivo = date('d-m-Y', time());

            $arquivo = __DIR__.'/../Logs/Logs_'.$tipo.'_'.$dataArquivo.'.txt';

            $referencia = $_SERVER['SERVER_NAME'];
            $host = $_SERVER['HTTP_HOST'];

            

            // se o cookie não existe
            if ( !isset($_COOKIE['logLive']) ) {
                // Cria um cookie com o tempo de vida de 24 horas
                setcookie('logLive', $data, time()+60*60*24);
                /**
                 * seta o mode para 'w+' para criar o arquivo e sempre colocar o ponteiro 
                 * no inicio do arquivo, criando um arquivo de log novo
                */ 
                $mode = 'w+';
            }else {
                // se o cookie existe 
                /**
                 * seta o mode para 'a+' para abrir ou criar o arquivo(se não existir)
                 * e sempre colocar o ponteiro no final do arquivo, escrevendo uma nova
                 * linha de log até expirar o cookie
                */
                $mode = 'a+';
            }
            
            $log = "$data - $codigo - $msg - $tipo - $host - $referencia ".PHP_EOL;


            $fo = fopen($arquivo, $mode);

            fwrite($fo, $log);

            fclose($fo);
        }
    }

?>