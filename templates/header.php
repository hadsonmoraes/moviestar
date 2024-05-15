<?php
require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$flassMessage = $message->getMessage();

if (!empty($flassMessage["msg"])) {
  // Limpar a mensagem
  $message->clearMessage();
}

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(false);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MovieStar</title>
  <link rel="shortcut icon" href="<?= $BASE_URL ?>img/moviestar.ico" type="image/x-icon">
  <!-- CSS -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/style.css">
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
  <header>
    <nav id="main-navbar" class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a href="<?= $BASE_URL ?>" class="navbar-brand">
          <img src="<?= $BASE_URL ?>img/logo.svg" alt="MovieStar" id="logo">
          <span id="moviestar-title">MovieStar</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <form action="<?= $BASE_URL ?>search.php" method="get" id="search-form" class="d-flex my-2 my-lg-0">
          <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar Filmes" aria-label="Search">
          <button type="submit" class="btn my-2 my-sm-0">
            <i class="fas fa-search"></i>
          </button>
        </form>
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="navbar-nav">

            <?php if ($userData) : ?>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>newmovie.php" class="nav-link"><i class="far fa-plus-square"></i>
                  Incluir Filme
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">Meus Filmes</a>
              </li>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
                  <?= $userData->name ?>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <?php if (!empty($flassMessage["msg"])) : ?>
    <div class="msg-container">
      <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
    </div>
  <?php endif; ?>