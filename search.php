<?php
  require_once "app/controllers/ProdutosController.php";
  
  use App\Controllers\ProdutosController;

  $serach = new ProdutosController();

  $results = $serach->search($_GET['busca']);
?>

<!doctype html>
<html>
<head>
  <title>Webjump | Backend Test | Search</title>
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
<!-- Header -->
  <!-- Main Content -->
  <main class="content">
  <div>
      <form action="search.php" method="get">
        <div class="input-field">
          <label for="search" class="label">Busca</label>
          <input type="text" name="busca" id="search" value="<?PHP echo $_GET['busca']; ?>" class="input-text">
          <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
      </form>
    </div>
    <div class="header-list-page">
      <h1 class="title">Search</h1>
    </div>
    <div class="infor">
      Sua busca encontrou <?PHP echo count($results); ?> resultados.
    </div>
    <ul class="product-list">
      <?PHP
        foreach ($results as $key => $produto) {
          
          echo "
            <li>
              <a href='showProduct.php?id=".$produto['id']."'>
                <div class='product-image'>
                  <img src='assets/images/product/".$produto['sku'].".png' layout='responsive' width='164' height='145' alt='".$produto['nome']."' />
                </div>
                <div class='product-info'>
                  <div class='product-name'><span>".$produto['nome']."</span></div>
                  <div class='product-price'><span class='special-price'>".mt_rand(0, 999)." available</span> <span>R$".number_format($produto['preco'], 2, ',', '.')."</span></div>
                  <div>
                    ";
                    $rates = mt_rand(0, 5);
                    switch ($rates) {
                      case 0:
                        echo"
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                        ";
                        break;
                      case 1:
                        echo"
                          <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                          
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                        ";
                        break;
                        case 2:
                          echo"
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          ";
                          break;
                        case 3:
                          echo"
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          ";
                          break;
                        case 4:
                          echo"
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            
                            <img src='assets/images/rate_outline.png' alt='rate_outline' style='width: 12px;'>
                          ";
                          break;
                        case 5:
                          echo"
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                            <img src='assets/images/rate_fill.png' alt='rate_outline' style='width: 12px;'>
                          ";
                          break;
                    }
                    
                    echo "
                  </div>
                </div>
              </a>
            </li>
          ";
        }
      ?>
    </ul>
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
