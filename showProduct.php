<?php
  include_once "app/controllers/ProdutosController.php";
  include_once "app/controllers/CategoriasController.php";
  $id = $_GET['id'];
  use App\Controllers\ProdutosController;
  use App\Controllers\CategoriasController;
  
  $categorias = new CategoriasController();
  $categoriaArr = $categorias->select();

  $produtos = new ProdutosController();
  $produtoArr = $produtos->select($id);
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
      <h1 class="title"><?PHP echo $produtoArr[0]['nome']; ?></h1>
      <a href="index.php" class="btn-action">Home</a>
    </div>

    <div class="container">
      <div class="container-left">
        <div class="left-content">
          <img src="assets/images/product/<?php echo $produtoArr[0]['sku']; ?>.png" alt="<?php echo $produtoArr[0]['nome']; ?>" style="max-width: 90%;">
        </div>
        <div class="right-content">
          <div class="card mt-4">
            <h2><?PHP echo $produtoArr[0]['nome']; ?></h2>
            
            <span>
              <?php
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
              ?>
              (<?php echo mt_rand(0, 999); ?>)
            </span>
            
            <p><?PHP echo $produtoArr[0]['descricao']; ?></p>
          </div>
          <a href="#">Mais informações</a>
          <div class="card mt-4">
            <div class="card mt-4">
              Cor: 
              <div style="width: 16px; height: 16px; background: #000;"></div>
              Preto
              <div style="width: 16px; height: 16px; background: blue;"></div>
              Azul
            </div>

            <div class="card mt-4">
              <span>Tamanho: 42/43 43/44</span>
            </div>
          </div>
          <a href="#">política de troca e devolução</a>
        </div>
      </div>
  
      <div class="container-right">
        <div class="card mt-4">
          <h1>R$ <?PHP echo number_format($produtoArr[0]['preco'], 2, ',', '.'); ?></h1>
          <h3>à vista no cartão de crédito</h3>
          <a href="#">mais formas de pagamento</a>
        </div>
  
        <div class="card mt-4">
          <form>
            <label for="frete">Calculando frete e prazo</label>
            <input type="text" name="frete" value="">
            <button>Calcular</button>
          </form>
        </div>
  
        <div class="card mt-4">
          <form>
            <button class="btn btn-primary w-full">Comprar</button>
          </form>
        </div>
      </div>
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
