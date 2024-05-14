<?php
require_once("templates/header.php");
// Verifica se o usuário esta autenticado
require_once("dao/movieDAO.php");
require_once("models/Movie.php");

$id = filter_input(INPUT_GET, "id");

$movie;

$movieDao = new MovieDAO($conn, $BASE_URL);

if(empty($id)){
  $message->setMessage("O filme não foi encontrado!", "error", "index.php");
}else{
  $movie = $movieDao->findById($id);
// Verifica se o filme existe
  if(!$movie){
    $message->setMessage("O filme não foi encontrado!", "error", "index.php");
  }
}

// Checar se o filme é do usuario
$userOwnsMovie = false;

if(!empty($userData)){
  if($userData->id === $movie->users_id){
    $userOwnsMovie = true;
  }
}

// restar as revies do filme


?>