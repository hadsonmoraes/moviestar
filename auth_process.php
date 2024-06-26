<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");


$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// verifica o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Verificacao do tipo de formulário
if ($type === "register") {

  $name = filter_input(INPUT_POST, "name");
  $lastname = filter_input(INPUT_POST, "lastname");
  $email = filter_input(INPUT_POST, "email");
  $password = filter_input(INPUT_POST, "password");
  $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

  // verificação de dados minimos
  if ($name && $lastname && $email && $password) {

    // Verificar se as senhas batem
    if ($password === $confirmpassword) {

      // Verificar se o e-mail já esta está cadastrado no sistema
      if ($userDao->findByEmail($email) === false) {
        $user = new User();
        // Criação de token e senha
        $userToken = $user->generateToken();
        $finalPassword = $user->generatePassword($password);

        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->password = $finalPassword;
        $user->token = $userToken;

        $auth = true;
        $userDao->create($user, $auth);
      } else {
        // enviar uma msg de erro, usuario ja existe
        $message->setMessage("Usuario já cadastrado, tente outro email.", "error", "back");
      }
    } else {
      // enviar uma msg de erro, se as senhas não batem
      $message->setMessage("As senhas não são iguais.", "error", "back");
    }
  } else {
    // enviar uma msg de erro, de dados faltantes
    $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
  }
} else if ($type === "login") {
  $email = filter_input(INPUT_POST, "email");
  $password = filter_input(INPUT_POST, "password");

  // Tenta autentica usuário 

  if ($userDao->authenticateUser($email, $password)) {
    $message->setMessage("Seja bem vindo!", "success", "editprofile.php");
    // redireciona o usuário, caso não conseguir autenticar
  } else {
    $message->setMessage("Usuario e/ou senhas incorretos.", "error", "back");
  }
} else {
  $message->setMessage("Informações inválidas!", "error", "index.php");
}
