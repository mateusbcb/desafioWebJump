<?php
  include_once "app/controllers/CategoriasController.php";
  
  use App\Controllers\CategoriasController;

  $categorias = new CategoriasController();

  if ( isset($_GET['itens_pagina']) ) {
    $itens_pagina = $_GET['itens_pagina'];
  }else {
    $itens_pagina = 5;
  }

  $categoriasArr = $categorias->select('', true, $itens_pagina);
?>

<!doctype html>
<html>
<head>
  <title>Webjump | Backend Test | Categories</title>
  <meta charset="utf-8">

<link  rel="stylesheet" type="text/css"  media="all" href="assets/css/style.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">
<meta name="viewport" content="width=device-width,minimum-scale=1">
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script></head>
  <!-- Header -->
<amp-sidebar id="sidebar" class="sample-sidebar" layout="nodisplay" side="left">
  <div class="close-menu">
    <a on="tap:sidebar.toggle">
      <img src="assets/images/bt-close.png" alt="Close Menu" width="24" height="24" />
    </a>
  </div>
  <a href="index.php"><img src="assets/images/menu-go-jumpers.png" alt="Welcome" width="200" height="43" /></a>
  <div>
    <ul>
      <li><a href="categories.php" class="link-menu">Categorias</a></li>
      <li><a href="products.php" class="link-menu">Produtos</a></li>
    </ul>
  </div>
</amp-sidebar>
<header>
  <div class="go-menu">
    <a on="tap:sidebar.toggle">☰</a>
    <a href="index.php" class="link-logo"><img src="assets/images/go-logo.png" alt="Welcome" width="69" height="430" /></a>
  </div>
  <div class="right-box">
    <span class="go-title">Administration Panel</span>
  </div>    
</header>  
<!-- Header --><body>
  <!-- Main Content -->
  <main class="content">
    <div class="header-list-page">
      <h1 class="title">Categories</h1>
      <a href="addCategory.php" class="btn-action">Add new Category</a>
    </div>
    <div class="filter">
      <form action="categories.php" method="GET">
        <div class="input-field">
          <label for="itens_pagina" class="label">
            Itens Por página
          </label>
          <select name="itens_pagina" id="itens_pagina" class="input-text" style="width: 100px;">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>
          <input type="submit" value="Enviar" class="btn btn-primary">
        </div>
      </form>
    </div>
    <table class="data-grid">
      <tr class="data-row">
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Name</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Code</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>
      <?php
        foreach ($categoriasArr['results'] as $key => $categoria) {
          echo "
          <tr class='data-row'>
            <td class='data-grid-td' style='width: 80%;'>
              <span class='data-grid-cell-content'>".$categoria['nome']."</span>
            </td>
          
            <td class='data-grid-td'>
              <span class='data-grid-cell-content'>".$categoria['codigo']."</span>
            </td>
          
            <td class='data-grid-td'>
              <div class='actions' style='display: flex;'>
                <form action='editCategory.php?id=".$categoria['id']."' method='GET'>
                  <input type='hidden' name='id' value='".$categoria['id']."'>
                  <input type='submit' class='action edit btn' value='Editar'>
                </form>

                <form action='routes/excluirCategoria.php' method='POST'>
                  <input type='hidden' name='id' value='".$categoria['id']."'>
                  <input type='submit' class='action delete btn' value='Delete'>
                </form>
              </div>
            </td>
          </tr>
          ";
        }
      ?>
    </table>
    <div class="pagination">
      <?php
        if ($categoriasArr['pagina_anterior'] != null) {
          echo "<a href='http://localhost/desafioWebJump/categories.php?itens_pagina=$itens_pagina&pagina=".$categoriasArr['pagina_anterior']."' class='btn'>Anterior</a>";
        }else {
          echo "<a class='btn desable'>Anterior</a>";
        }

        if ($categoriasArr['total_paginas'] > 1) {
          foreach ($categoriasArr['paginas'] as $key => $pagina) {
            if ($pagina > 0) {
              echo "<a href='http://localhost/desafioWebJump/categories.php?itens_pagina=$itens_pagina&pagina=$pagina' class='"; if ($pagina == $categoriasArr['pagina_atual']) { echo 'btn btn-primary active'; }else{ echo 'btn btn-primary';} echo "'>$pagina</a>";
            }
          }
        }

        if ($categoriasArr['pagina_proxima'] != null) {
          echo "<a href='http://localhost/desafioWebJump/categories.php?itens_pagina=$itens_pagina&pagina=".$categoriasArr['pagina_proxima']."' class='btn'>Próxima</a>";
        }else {
          echo "<a class='btn desable'>Próxima</a>";
        }
      ?>
    </div>
  </main>
  <!-- Main Content -->

  <!-- Footer -->
<footer>
	<div class="footer-image">
	  <img src="assets/images/go-jumpers.png" width="119" height="26" alt="Go Jumpers" />
	</div>
	<div class="email-content">
	  <span>go@jumpers.com.br</span>
	</div>
</footer>
 <!-- Footer --></body>
</html>
