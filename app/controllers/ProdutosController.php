<?php

    namespace App\Controllers;

    include_once "app/database/Conexao.php";

    use App\Database\Conexao;

    class ProdutosController 
    {
        public $db;
        public function __construct()
        {
            $this->db = new Conexao();
        }

        public function insert()
        {
            $pdo = $this->db->db();

            $sku            = $_REQUEST['sku'];
            $nome           = $_REQUEST['nome'];
            $preco          = str_replace([',', '-', '_', ' '], '.', $_REQUEST['preco']);
            $quantidade     = $_REQUEST['quantidade'];
            $categorias     = json_encode($_REQUEST['categorias']);
            $descricao      = $_REQUEST['descricao'];

            $sql = "INSERT INTO produtos (sku, nome, preco, quantidade, categorias, descricao)
                    VALUE (:sku, :nome, :preco, :quantidade, :categorias, :descricao)";
            
            $stmt  = $pdo->prepare( $sql );
            $stmt->bindParam( ':sku', $sku );
            $stmt->bindParam( ':nome', $nome );
            $stmt->bindParam( ':preco', $preco );
            $stmt->bindParam( ':quantidade', $quantidade );
            $stmt->bindParam( ':categorias', $categorias );
            $stmt->bindParam( ':descricao', $descricao );

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
                $sql = "SELECT * FROM produtos";
            }else {
                $sql = "SELECT * FROM produtos WHERE id = $id";
            }
            
            foreach ($pdo->query($sql) as $row) {
                
                array_push($valores, $row);
            }
            
            return $valores;
        }

        public function update($id)
        {
            $pdo = $this->db->db();

            $sku            = $_REQUEST['sku'];
            $nome           = $_REQUEST['nome'];
            $preco          = str_replace([',', '-', '_', ' '], '.', $_REQUEST['preco']);
            $quantidade     = $_REQUEST['quantidade'];
            $categorias     = json_encode($_REQUEST['categorias']);
            $descricao      = $_REQUEST['descricao'];

            $stmt = $pdo->prepare("UPDATE produtos SET nome = :nome, sku = :sku, preco = :preco, descricao = :descricao, quantidade = :quantidade, categorias = :categorias WHERE id = :id");
            $result = $stmt->execute([
                ':nome'       => $nome,
                ':sku'        => $sku,
                ':preco'      => $preco,
                ':descricao'  => $descricao,
                ':quantidade' => $quantidade,
                ':categorias' => $categorias,
                ':id'         => $id,
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
            $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = $id");
            
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