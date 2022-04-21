<?php

    namespace App\Controllers;

    include_once "app/database/Conexao.php";

    use App\Database\Conexao;
    use PDO;

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

            // $valores = [];

            // $sql = "SELECT * FROM produtos WHERE nome LIKE \'%\'\"pro\"\'%\';";

            // $stmt  = $pdo->prepare( $sql );
            
            // $results = $stmt->execute([
            //     ':nome' => "'%'$busca'%'"
            // ]);
            // return $results;
            
            // foreach ($pdo->query($sql) as $row) {
                
            //     array_push($valores, $row);
            // }
            
            // return $valores;
        }
    }

?>