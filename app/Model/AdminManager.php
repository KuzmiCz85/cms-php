<?php
class AdminManager
{
  public function getPages(): array
  {
    return Db::queryAll("
      SELECT id, name
      FROM page
    ");
  }

  public function getPage(string $page): array
  {
    return Db::queryOne("
      SELECT *
      FROM page
      WHERE id = ?
    ",
    array($page));
  }

  public function editPage(string $page, string $newProp): int
  {
    return Db::query("
      UPDATE page
      SET name = ?
      WHERE id = ?
    ",
    array_merge(array($newProp), array($page)));
  }
}
