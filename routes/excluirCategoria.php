<?php

    namespace routes\addCategoria;

    include_once "../app/controllers/CategoriasController.php";
    include_once "../app/database/Conexao.php";

    use App\Controllers\CategoriasController;

    $categorias = new CategoriasController();

    $id = $_POST['id'];

    $categoria = $categorias->delete($id);

    if ($categoria) {
        header('Location: http://localhost/desafioWebJump/categories.php');
    } else {
        echo "Erro ao cadastrar uma nova categoria no Banco de dados!";
    }
?>