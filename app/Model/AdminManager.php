<?php
class AdminManager
{
  private function nullHome(): void
  {
    Db::query("
      UPDATE page
      SET home = ?
      WHERE home = ?
    ",
    array_merge(array(0), array(1)));
  }

  public function getPages(): array
  {
    return Db::queryAll("
      SELECT id, name
      FROM page
    ");
  }

  public function addPage(string $name): int
  {
    return Db::query("
      INSERT INTO page (name)
      VALUES ('$name');
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

  public function editPage(string $page, stdClass $params): int
  {
    $params = (array) $params;  // Parse from stdClass to array

    // Check if homepage is changed. Turn-off obsolete home if true
    if ($params['home'] === "1") $this->nullHome();

    var_dump($params); // Print for JS console.log

    return Db::query("
      UPDATE page
      SET `" . implode('` = ?, `', array_keys($params)) . "` = ?
      WHERE id = ?
    ",
    array_merge(array_values($params), array($page)));
  }
}
