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

        public function select($id = '', $paginacao = true, $total_reg = 5)
        {
            $pdo = $this->db->db();

            if ($paginacao == true) {

                if ( isset($_GET['pagina']) ) {
                    $pagina = $_GET['pagina'];
                }else {
                    $pagina = 1;
                }
                
                if(!$pagina) {
                    $pc = "1";
                }else {
                    $pc = $pagina;
                }

                $inicio = $pc - 1;
                $inicio = $inicio * $total_reg;

                if ($id == '') {

                    $limite = $pdo->query("SELECT * FROM categorias LIMIT $inicio,$total_reg");
                    $todos  = $pdo->query("SELECT * FROM categorias");

                }else {

                    $limite = $pdo->query("SELECT * FROM categorias  WHERE id = $id LIMIT $inicio,$total_reg");
                    $todos  = $pdo->query("SELECT * FROM categorias  WHERE id = $id");

                }

                $tr = $todos->rowCount($todos); // verifica o número total de registros
                $tp = $tr / $total_reg; // verifica o número total de páginas

                $anterior = $pc -1;
                $proximo = $pc +1;

                if ($pc > 1) {
                    $pagina_anterior = $anterior;
                }else {
                    $pagina_anterior = null;
                }

                if ($pc < $tp) {
                    $pagina_proxima = $proximo;
                }else {
                    $pagina_proxima = null;
                }

                $valores_paginado = [];
                $paginas = [];

                foreach ($limite as $key => $value) {
                    array_push($valores_paginado, $value);
                    array_push($paginas, $key);
                }

                $paginacao_array = [
                    'results' => $valores_paginado,
                    'total_registros' => $tr,
                    'total_paginas' => $tp,
                    'pagina_anterior' => $pagina_anterior,
                    'pagina_proxima' => $pagina_proxima,
                    'paginas' => $paginas,
                    'pagina_atual' => $pc,
                ];

                $this->log->log(200, "Categorias selecionadas", "Categorias");

                return $paginacao_array;
            }else {
                
                $valores = [];
                $paginas = [];
    
                if ($id == '') {
                    $sql = "SELECT * FROM categorias";
                }else {
                    $sql = "SELECT * FROM categorias WHERE id = $id";
                }
                
                foreach ($pdo->query($sql) as $key => $row) {
                    
                    array_push($valores, $row);
                    array_push($paginas, $key);
                }

                $paginacao_array = [
                    'results' => $valores,
                    'total_registros' => 0,
                    'total_paginas' => 0,
                    'pagina_anterior' => 0,
                    'pagina_proxima' => 0,
                    'paginas' => $paginas,
                    'pagina_atual' => 0,
                ];

                $this->log->log(200, "Categorias selecionadas", "Categorias");
                
                return $paginacao_array;
            }
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