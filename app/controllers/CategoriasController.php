<?php

    namespace App\Controllers;

    include_once "app/database/Conexao.php";

    use App\Database\Conexao;

    class CategoriasController 
    {
        public $db;
        public function __construct()
        {
            $this->db = new Conexao();
        }

        public function insert()
        {
            $pdo = $this->db->db();

            $nome = $_REQUEST['nome'];
            $codigo = $_REQUEST['codigo'];

            $sql = "INSERT INTO categorias (codigo, nome) VALUE (:codigo, :nome)";
            
            $stmt  = $pdo->prepare( $sql );
            $stmt->bindParam( ':codigo', $codigo );
            $stmt->bindParam( ':nome', $nome );

            $result = $stmt->execute();

            if ( ! $result )
            {
                var_dump( $stmt->errorInfo() );
                exit;
            }

            return $result;
        }

        public function select($id = '')
        {
            $pdo = $this->db->db();

            $valores = [];

            if ($id == '') {
                $sql = "SELECT * FROM categorias";
            }else {
                $sql = "SELECT * FROM categorias WHERE id = $id";
            }
            
            foreach ($pdo->query($sql) as $row) {
                
                array_push($valores, $row);
            }
            
            return $valores;
        }

        public function update($id)
        {
            $pdo = $this->db->db();

            $codigo = $_REQUEST['codigo'];
            $nome   = $_REQUEST['nome'];
            
            $stmt = $pdo->prepare("UPDATE categorias SET codigo = :codigo, nome = :nome WHERE id = :id");
            $result = $stmt->execute([
                ':codigo' => $codigo,
                ':nome'   => $nome,
                ':id'     => $id,
            ]);

            if ( ! $result )
            {
                var_dump( $stmt->errorInfo() );
                exit;
            }

            return $result;
        }

        public function delete($id)
        {
            $pdo = $this->db->db();
            $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = $id");
            
            $result = $stmt->execute();
            
            if ( ! $result )
            {
                var_dump( $stmt->errorInfo() );
                exit;
            }

            return $result;
        }
    }

?>