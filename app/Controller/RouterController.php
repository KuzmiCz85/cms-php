<?php
class RouterController {

  public function getPage(string $url): void
  {
    $url = ltrim($url, "/");
    $url = trim($url);

    $page = Db::querySingle('SELECT * FROM pages WHERE name = ?', array($url));

    if(empty($page))
      exit;

    echo "Called page has id " . $page['id'] . "<br>";
  }
}
