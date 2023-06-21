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

  // Get blocks fields from config file
  private function addFields(array $blocks) : array
  {
    foreach ($blocks as $i=>$block) {
      $blockCfg = file_get_contents("./app/config/templates/blocks/" . $block['block'] . ".json");
      $blockCfg = json_decode($blockCfg);
      $fields = [];

      foreach ($blockCfg->fields as $field) {
        array_push($fields, get_object_vars($field));
      }

      print_r($fields);

      $block['fields'] = $fields;

      $blocks[$i] = $block;
    }

    return $blocks;
  }

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

  public function getPageBlocks(string $page): array
  {
    $pageBlocks = Db::queryAll("
      SELECT *
      FROM page_block
      WHERE page = ?
    ",
    array($page));

    return $this->addFields($pageBlocks);
  }

  public function editPage(string $page, stdClass $params): int
  {
    $params = (array) $params;  // Parse from stdClass to array

    // Check if homepage is changed. Turn-off obsolete home if true
    if ($params['home'] === "1") $this->nullHome();

    print_r($params); // Print for JS console.log

    return Db::query("
      UPDATE page
      SET `" . implode('` = ?, `', array_keys($params)) . "` = ?
      WHERE id = ?
    ",
    array_merge(array_values($params), array($page)));
  }

  public function editBlocks(string $page, array $blocks): int
  {
    $res = 0;

    foreach ($blocks as $block) {
      $params = (array) $block; // Parse from stdObject to array

      print_r($params); // Print for JS console.log

      $resCur = Db::query("
        UPDATE page_block
        SET `" . implode('` = ?, `', array_keys($params)) . "` = ?
        WHERE id = ?
      ",
      array_merge(array_values($params), array($block->id)));

      $res = $res + $resCur;
    }

    return $res;
  }
}
