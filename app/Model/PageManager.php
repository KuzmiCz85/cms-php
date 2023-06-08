<?php
class PageManager {

  public function getHome(): array|bool
  {
    return Db::queryOne("
      SELECT *
      FROM page
      WHERE home = ?
    ",
    array(true));
  }
}
