<?php
class BlockManager {

  // Get blocks fields from config file
  private function getBlocksFields(array $blocks) : array
  {
    foreach ($blocks as $i=>$block) {
      $blockCfg = file_get_contents("./app/config/templates/blocks/" . $block['block'] . ".json");
      $blockCfg = json_decode($blockCfg);
      $fields = [];

      foreach ($blockCfg->fields as $field) array_push($fields, get_object_vars($field));

      $block['name'] = $blockCfg->name;
      $block['fields'] = $fields;

      $blocks[$i] = $block;
    }

    return $blocks;
  }

  private function parseBlocks($blocks) : array
  {
    foreach ($blocks as $i=>$block) {
      $block['data'] = json_decode($block['data']); // Parse block data from string

      // Parse block from array to object
      $objBlock = new stdClass();
      foreach ($block as $key=>$val)
        $objBlock->{$key} = $val;

      $blocks[$i] = $objBlock; // Add parsed object to array of blocks
    }

    $parsedBlocks = $blocks;

    return $parsedBlocks;
  }

  public function getBlocks(string $page): array
  {
    $pageBlocks = Db::queryAll("
      SELECT *
      FROM page_block
      WHERE page = ?
    ",
    array($page));

    // Get fields for block from config file
    $blocksWithFields = $this->getBlocksFields($pageBlocks);
    // Parse each block data from string to object
    $blocks = $this->parseBlocks($blocksWithFields);

    return $blocks;
  }

  public function editBlocks(string $page, array $blocks): int
  {
    $res = 0;

    foreach ($blocks as $block) {
      $block->data = json_encode($block->data); // Parse block data to string
      $params = (array) $block; // Parse from stdObject to array

      var_dump($params); // Print for JS console.log

      $resCur = Db::query("
        UPDATE page_block
        SET `" . implode('` = ?, `', array_keys($params)) . "` = ?
        WHERE id = ?
      ",
      array_merge(array_values($params), array($block->id)));

      $res = $res + $resCur;
    }

    return $res;  // Returns number of edite rows
  }

  public function getApprBlocks(): array
  {
    $files = scandir('./app/config/templates/blocks');
    $blocks = [];

    // Pick only json files
    foreach ($files as $file) {
      if (str_ends_with($file, '.json')) {
        $block = str_replace('.json', "", $file);

        array_push($blocks, $block);
      }
    }
    return $blocks;
  }

  public function addBlock(string $page, string $block): int
  {
    return Db::query("
      INSERT INTO page_block (page, block)
      VALUES ('$page', '$block');
    ");
  }

  public function deleteBlock(string $id, string $page): int
  {
    return Db::query("
      DELETE FROM page_block
      WHERE id = ? AND page = ?;
    ",
    array_merge(array($id), array($page)));
  }

  public function deletePageBlocks(string $page): int
  {
    return Db::query(
      "
        DELETE FROM page_block
        WHERE page = ?;
      ",
      array($page));
  }
}
