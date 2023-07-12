<?php
class PageManager {

  public function getHome(): array|bool
  {
    return Db::queryOne("
      SELECT *
      FROM page
      WHERE is_home = ?
    ",
    array(true));
  }

  public function getPage($slug): array|bool
  {
    return Db::queryOne("
      SELECT *
      FROM page
      WHERE url_slug = ?
    ",
    array($slug));
  }
}
