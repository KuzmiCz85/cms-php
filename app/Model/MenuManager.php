<?php
class MenuManager {

  public function getItems(): array|bool
  {
    return Db::queryAll("
      SELECT name, url_slug
      FROM page
      WHERE in_menu = ?
    ",
    array(true));
  }
}
