<?php
  include_once "app/controllers/ProdutosController.php";
  
  use App\Controllers\ProdutosController;

  $produtos = new ProdutosController();

  if ( isset($_GET['itens_pagina']) ) {
    $itens_pagina = $_GET['itens_pagina'];
  }else {
    $itens_pagina = 5;
  }

  $produtosArr = $produtos->select('', true, $itens_pagina);
?>

<!doctype html>
<html>
<head>
  <title>Webjump | Backend Test | Products</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,minimum-scale=1">

  <link  rel="stylesheet" type="text/css"  media="all" href="assets/css/style.css" />

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">

  <style amp-boilerplate>
    body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
  </style>
  
  <noscript>
    <style amp-boilerplate>
      body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}
    </style>
  </noscript>

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
<!-- Header -->
<body>
  <!-- Main Content -->
  <main class="content">
    <div class="header-list-page">
      <h1 class="title">Products</h1>
      <a href="addProduct.php" class="btn-action">Add new Product</a>
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
            <span class="data-grid-cell-content">SKU</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Price</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Quantity</span>
        </th>
        <th class="data-grid-th">
            <span class="data-grid-cell-content">Categories</span>
        </th>

        <th class="data-grid-th">
            <span class="data-grid-cell-content">Actions</span>
        </th>
      </tr>
      <?php
        foreach ($produtosArr['results'] as $key => $produto) {
          echo "
            <tr class='data-row'>
              <td class='data-grid-td' style='width: 30%;'>
                <span class='data-grid-cell-content'>".$produto['nome']."</span>
              </td>
            
              <td class='data-grid-td'>
                <span class='data-grid-cell-content'>".$produto['sku']."</span>
              </td>

              <td class='data-grid-td'>
                <span class='data-grid-cell-content'>R$ ".number_format($produto['preco'], 2, ',', '.')."</span>
              </td>

              <td class='data-grid-td'>
                <span class='data-grid-cell-content'>".$produto['quantidade']."</span>
              </td>

              <td class='data-grid-td'>
                <span class='data-grid-cell-content'>
                  ";
                    foreach(json_decode($produto['categorias']) as $categoria){
                      echo $categoria . "<br />";
                    }
                  echo"
                </span>
              </td>
            
              <td class='data-grid-td'>
                <div class='actions' style='display: flex;'>
                  <form action='editProduct.php?id=".$produto['id']."' method='GET'>
                    <input type='hidden' name='id' value='".$produto['id']."'>
                    <input type='submit' class='action edit btn' value='Editar'>
                  </form>

                <form action='routes/excluirProduto.php' method='POST'>
                  <input type='hidden' name='id' value='".$produto['id']."'>
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
        if ($produtosArr['pagina_anterior'] != null) {
          echo "<a href='http://localhost/desafioWebJump/products.php?itens_pagina=$itens_pagina&pagina=".$produtosArr['pagina_anterior']."' class='btn'>Anterior</a>";
        }else {
          echo "<a class='btn desable'>Anterior</a>";
        }

        if ($produtosArr['total_paginas'] > 1) {
          foreach ($produtosArr['paginas'] as $key => $pagina) {
            if ($pagina > 0) {
              echo "<a href='http://localhost/desafioWebJump/products.php?itens_pagina=$itens_pagina&pagina=$pagina' class='"; if ($pagina == $produtosArr['pagina_atual']) { echo 'btn btn-primary active'; }else{ echo 'btn btn-primary';} echo "'>$pagina</a>";
            }
          }
        }

        if ($produtosArr['pagina_proxima'] != null) {
          echo "<a href='http://localhost/desafioWebJump/products.php?itens_pagina=$itens_pagina&pagina=".$produtosArr['pagina_proxima']."' class='btn'>Próxima</a>";
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
  <!-- Footer -->
</body>
</html>
