<?php

class Db {
  private static PDO $stream;

  private static array $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false,
  );

  public static function connect(string $host, string $db, string $user, string $pwd): void
  {
    try {
      self::$stream = new PDO("mysql:host=$host;dbname=$db", $user, $pwd, self::$options);
      # echo ("Connected successfully<br>");
    } catch(PDOException $err) {
      # echo "Connection failed: " . $err->getMessage() . "<br>";
    }
  }

  public static function queryOne(string $query, array $params = array()): array|bool
  {
    $result = self::$stream->prepare($query);
    $result->execute($params);
    return $result->fetch();
  }

  public static function queryAll(string $query, array $params = array()): array|bool
  {
    $result = self::$stream->prepare($query);
    $result->execute($params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function querySingle(string $query, array $params = array()): string
  {
    $result = self::queryOne($query, $params);
    return $result[0];
  }
}
