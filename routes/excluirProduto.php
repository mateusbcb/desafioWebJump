<?php

    namespace routes\addCategoria;

    include_once "../app/controllers/ProdutosController.php";
    include_once "../app/database/Conexao.php";

    use App\Controllers\ProdutosController;

    $produtos = new ProdutosController();
    
    $id = $_POST['id'];

    $produto = $produtos->delete($id);
    
    if ($produto) {
        header('Location: http://localhost/desafioWebJump/products.php');
    } else {
        echo "Erro ao autualizar um novo produto no Banco de dados!";
        exit;
    }
?>