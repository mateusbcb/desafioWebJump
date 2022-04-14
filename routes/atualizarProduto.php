<?php

    namespace routes\addCategoria;

    include_once "../app/controllers/ProdutosController.php";
    include_once "../app/database/Conexao.php";

    use App\Controllers\ProdutosController;

    $id = $_POST['id'];

    $produtos = new ProdutosController();

    $produto = $produtos->update($id);

    if ($produto) {
        header('Location: http://localhost/desafioWebJump/products.php');
    } else {
        echo "Erro ao autualizar um novo produto no Banco de dados!";
        exit;
    }
?>