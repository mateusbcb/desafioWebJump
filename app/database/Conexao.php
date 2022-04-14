<?php

    namespace App\Database;
    use PDO;

    class Conexao {

        function __construct() {
            $this->db();
        }

        public function db()
        {
            try {

                $servidor   = 'localhost';
                $usuario    = 'root';
                $senha      = '';
                $banco      = 'desafiowebjump';
                
                $con = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

                return $con;

            } catch (\Throwable $th) {

                return $th->getMessage();
            }
            
        }
}
?>