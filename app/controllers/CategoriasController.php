<?php

    namespace App\Controllers;

    require_once __DIR__."/../database/Conexao.php";
    require_once __DIR__."/../database/Log.php";

    use App\Database\Conexao;
    use App\Database\Log;

    class CategoriasController 
    {
        public $db;
        public $log;
        public function __construct()
        {
            $this->db  = new Conexao();
            $this->log = new Log();
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

            $this->log->log(201, "Categoria inserida com sucesso", "Categorias");
            
            if ( !$result ){
                $this->log->log(401, "Erro ao inserir Categoria no Banco de Dados", "Categorias");
                
                printf("%s", 
                    [
                        $stmt->errorInfo()
                    ]
                );
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

            $this->log->log(200, "Categorias selecionadas", "Categorias");
            
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

            if ( !$result ){
                $this->log->log(401, "Erro ao atualizar Categoria no Banco de Dados", "Categorias");
                
                printf("%s", 
                    [
                        $stmt->errorInfo()
                    ]
                );
                exit;
            }

            $this->log->log(201, "Categoria atualizada com sucesso", "Categorias");

            return $result;
        }

        public function delete($id)
        {
            $pdo = $this->db->db();
            $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = $id");
            $result = $stmt->execute();
            
            if ( !$result ){
                $this->log->log(401, "Erro ao deletar Categoria no Banco de Dados", "Categorias");
                
                printf("%s", 
                    [
                        $stmt->errorInfo()
                    ]
                );
                exit;
            }

            $this->log->log(201, "Categoria removida com sucesso", "Categorias");
            
            return $result;
        }
    }

?>