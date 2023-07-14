<?php
class UserManager {

  public function login(string $name, string $pwd): void
  {
    $user = Db::queryOne("
      SELECT name, pwd
      FROM user
      WHERE name = ?
    ",array($name));

    if (!$user || $pwd != $user['pwd'])
      exit;
    $_SESSION['user'] = $user;
  }

  public function getUser(): ?array
  {
    if (isset($_SESSION['user']))
      return $_SESSION['user'];
    return null;
  }
}
