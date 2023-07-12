<?php
class MenuManager {

  public function getItems(): array|bool
  {
    $pageNames = [];

    $pages = Db::queryAll("
      SELECT name
      FROM page
      WHERE in_menu = ?
    ",
    array(true));

    foreach ($pages as $page) array_push($pageNames, $page['name']);

    return $pageNames;
  }
}
