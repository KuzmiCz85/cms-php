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

  public function get404(): array
  {
    $block404 = new stdClass();
    $block404->block = "404-section";
    $block404->data = "";

    return array(
      "name" => "404",
      "blocks" => [
        $block404
      ],
    );
  }
}
