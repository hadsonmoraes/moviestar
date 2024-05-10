<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDao($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

$fullName = $user->getFullName($userData);

if ($userData->image == "") {
  $userData->image = "user.png";
}

?>

<div id="main-container" class="container-fluid">
  <div class="col-md-12">
    <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="type" value="update">
      <div class="row">
        <div class="col-md-4">
          <h1><?= $fullName  ?></h1>
          <p class="page-description">
            Altere seus dados no formulário abaixo:
          </p>
          <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="name" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
          </div>
          <div class="mb-3">
            <label for="lastname" class="form-label">sobrenome:</label>
            <input type="lastname" class="form-control" id="lastname" name="lastname" placeholder="Digite o seu sobrenome" value="<?= $userData->lastname ?>">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu email" value="<?= $userData->email ?>">
          </div>
          <input type="submit" class="btn form-btn" value="Alterar">
        </div>
        <div class="col-md-4">
          <div id="profile-image-container" style="background-image url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')">
          </div>
          <div class="mb-3">
            <label for="image">Foto:</label>
            <input type="file" class="form-control" name="image" id="image">
          </div>
          <div class="mb-3">
            <label for="bio">Sobre você:</label>
            <textarea class="form-control" id="bio" name="bio" rows="5" placeholder="Conte quem você é, o que faz e onde trabalha..."><?= $userData->bio ?></textarea>
          </div>
        </div>
      </div>
    </form>
    <div class="row" id="change-password-container">
      <div class="col-md-4">
        <h2>Alterar senha:</h2>
        <p class="page-description">
          Digite a nova senha e confirme, para alterar sua senha:
        </p>
        <form action="<?= $BASE_URL ?>user_process.php" method="post">
          <input type="hidden" name="type" value="changepassword">
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
          </div>
          <div class="mb-3">
            <label for="confirmpassword" class="form-label">Confirmação de senha</label>
            <input type="password" class="form-control" id="cofirmpassword" name="confirmpassword" placeholder="Digite a sua nova senha">
          </div>
          <input type="submit" class="btn form-btn" value="Alterar senha">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
require_once("templates/footer.php")
?>