<?php
class AdminManager
{
  public function getPages(): array
  {
    return Db::queryAll("
      SELECT name
      FROM page
    ");
  }

  public function getPage(string $page): array
  {
    return Db::queryOne("
      SELECT *
      FROM page
      WHERE name = ?
    ",
    array($page));
  }
}
