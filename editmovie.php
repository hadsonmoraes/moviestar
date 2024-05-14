<?php
require_once("templates/header.php");
// Verifica se o usuário esta autenticado
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDao($conn, $BASE_URL);
$movieDao = new MovieDao($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
$userMovies = $movieDao->getMoviesByUserId($userData->id)
?>


<div id="main-container" class="container-fluid">
  <h2 class="section-title">Filmes novos</h2>
  <p class="section-description">Veja as críticas dos últimos filmes adicionados</p>
  <div class="moveis-container">
    <?php foreach ($latestMovies as $movie) : ?>
      <?php require("templates/movie_card.php"); ?>
    <?php endforeach; ?>
    <?php if (count($latestMovies) === 0) : ?>
      <p class="empty-list">Ainda não há filmes cadastrados!</p>
    <?php endif; ?>
  </div>
  <h2 class="section-title">Ação</h2>
  <p class="section-description">Veja os melhores filmes de ação</p>
  <div class="moveis-container">
    <?php foreach ($actionMovies as $movie) : ?>
      <?php require("templates/movie_card.php"); ?>
    <?php endforeach; ?>
    <?php if (count($actionMovies) === 0) : ?>
      <p class="empty-list">Ainda não há filmes de ação cadastrados!</p>
    <?php endif; ?>
  </div>

  <h2 class="section-title">Comédia</h2>
  <p class="section-description">Veja os melhores filmes de comédia</p>
  <div class="moveis-container">
    <?php foreach ($comedyMovies as $movie) : ?>
      <?php require("templates/movie_card.php"); ?>
    <?php endforeach; ?>
    <?php if (count($comedyMovies) === 0) : ?>
      <p class="empty-list">Ainda não há filmes de comédia cadastrados!</p>
    <?php endif; ?>
  </div>
</div>

<?php
require_once("templates/footer.php")
?>