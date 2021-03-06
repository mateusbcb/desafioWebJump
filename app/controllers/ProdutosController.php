<?php

    namespace App\Controllers;

    require_once __DIR__."/../database/Conexao.php";
    require_once __DIR__."/../database/Log.php";

    use App\Database\Conexao;
    use App\Database\Log;
    use PDO;

    class ProdutosController 
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

            $sku            = $_REQUEST['sku'];
            $nome           = $_REQUEST['nome'];
            $preco          = str_replace([',', '-', '_', ' '], '.', $_REQUEST['preco']);
            $quantidade     = $_REQUEST['quantidade'];
            $categorias     = json_encode($_REQUEST['categorias']);
            $descricao      = $_REQUEST['descricao'];

            // upload de imagem
            $target_dir = "../assets/images/product/";
            $target_file = $target_dir . $sku . ".png";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Verifique se o arquivo de imagem é uma imagem real ou uma imagem falsa
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                echo "O arquivo é uma imagem - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "O arquivo não é uma imagem.";
                $uploadOk = 0;
            }
            }

            // Verifique se o arquivo já existe
            if (file_exists($target_file)) {
                echo "Desculpe, o arquivo já existe.";
            $uploadOk = 0;
            }

            // Verifique o tamanho do arquivo
            if ($_FILES["image"]["size"] > 500000) {
                echo "Desculpe seu arquivo é muito grabde.";
            $uploadOk = 0;
            }

            // Permitir determinados formatos de arquivo
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "webp" ) {
                echo "Desculpe, apenas arquivos JPG, JPEG, PNG, GIF e webp são permitidos.";
                $uploadOk = 0;
            }

            // Verifique se $uploadOk está definido como 0 por um erro
            if ($uploadOk == 0) {
                echo "Desculpe, seu arquivo não foi carregado.";
            // se estiver tudo ok, tente fazer o upload do arquivo
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "O arquivo ". htmlspecialchars( basename( $_FILES["image"]["name"])). " foi carregado com sucesso.";
                } else {
                    echo "Desculpe, ocorreu um erro ao enviar seu arquivo.";
                }
            }

            $sql = "INSERT INTO produtos (sku, nome, imagem, preco, quantidade, categorias, descricao)
                    VALUE (:sku, :nome, :imagem, :preco, :quantidade, :categorias, :descricao)";
            
            $stmt  = $pdo->prepare( $sql );
            $stmt->bindParam( ':sku', $sku );
            $stmt->bindParam( ':nome', $nome );
            $stmt->bindParam( ':imagem', $target_file );
            $stmt->bindParam( ':preco', $preco );
            $stmt->bindParam( ':quantidade', $quantidade );
            $stmt->bindParam( ':categorias', $categorias );
            $stmt->bindParam( ':descricao', $descricao );

            $result = $stmt->execute();

            $this->log->log(201, "Produto inserido com sucesso", "Produtos");

            if ( !$result ){
                $this->log->log(401, "Erro ao inserir Produto no Banco de Dados", "Produtos");
                
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

                    $limite = $pdo->query("SELECT * FROM produtos LIMIT $inicio,$total_reg");
                    $todos  = $pdo->query("SELECT * FROM produtos");

                }else {

                    $limite = $pdo->query("SELECT * FROM produtos  WHERE id = $id LIMIT $inicio,$total_reg");
                    $todos  = $pdo->query("SELECT * FROM produtos  WHERE id = $id");

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

                $this->log->log(201, "Produtos selecionados com sucesso", "Produtos");

                return $paginacao_array;

            }else {

                $valores = [];
                $paginas = [];
    
                if ($id == '') {
                    $sql = "SELECT * FROM produtos";
                }else {
                    $sql = "SELECT * FROM produtos WHERE id = $id";
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

                $this->log->log(201, "Produtos selecionados com sucesso", "Produtos");

                return $paginacao_array;

            }
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

            if ( !$result ){
                $this->log->log(401, "Erro ao atualizar Produto no Banco de Dados", "Produtos");
                
                printf("%s", 
                    [
                        $stmt->errorInfo()
                    ]
                );
                exit;
            }

            $this->log->log(201, "Produto atualizado com sucesso", "Produtos");

            return $result;
        }

        public function delete($id)
        {
            $pdo = $this->db->db();
            $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = $id");
            
            $result = $stmt->execute();
            
            if ( !$result ){
                $this->log->log(401, "Erro ao deletar Produto no Banco de Dados", "Produtos");
                
                printf("%s", 
                    [
                        $stmt->errorInfo()
                    ]
                );
                exit;
            }
            
            $this->log->log(201, "Produto deletado com sucesso", "Produtos");

            return $result;
        }

        public function search($busca)
        {
            $pdo = $this->db->db();

            $sql = "SELECT * FROM produtos WHERE nome LIKE :nome";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(
                [
                    ':nome' => '%' . $busca . '%'
                ]
            );

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        }
    }

?>