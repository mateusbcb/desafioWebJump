<?php

    namespace routes\addCategoria;

    include_once "../app/controllers/CategoriasController.php";
    include_once "../app/database/Conexao.php";
    
    use App\Controllers\CategoriasController;

    $categorias = new CategoriasController();

    $categoria = $categorias->insert();

    if ($categoria) {
        header('Location: http://localhost/desafioWebJump/categories.php');
    } else {
        echo "Erro ao cadastrar uma nova categoria no Banco de dados!";
        exit;
    }
?>