<?php

class AdminController extends Controller {
  public function process(array $params): void
  {
    $adminMn = new AdminManager; // Init admin manager
    $blockMn = new BlockManager; // Init block manager
    $tempMn = new TemplateManager; // Init template manager
    $tempMn->setSource("app/admin/components/");

    // Save new data for page
    if (isset($params[1]) && $params[1] === "save") {
      $page = json_decode(file_get_contents("php://input"));
      // Edit page main data
      $adminMn->editPage($page->id, $page->data);
      // Edit page blocks
      if (isset($page->blocks)) $blockMn->editBlocks($page->id, $page->blocks);
      exit;
    }

    // Show list of pages
    if (isset($params[1]) && $params[1] === "pages" && empty($params[2])) {
      $this->data['pages'] = $adminMn->getPages();
    }

    // Add new page
    if (isset($params[1]) && $params[1] === "pages" && isset($params[2]) && $params[2] === "add") {
      $adminMn->addPage("Empty page"); // Add new page to Db
      $tempMn->include("group/pages-group/pages-group.phtml", '{
        "pages": ' . json_encode($adminMn->getPages()) . '
      }');
      exit;
    }

    // Delete page and related blocks
    if (isset($params[1]) && $params[1] === "delete-page") {
      $page = json_decode(file_get_contents("php://input"));
      $adminMn->deletePage($page->id);
      $blockMn->deletePageBlocks($page->id);
      exit;
    }

    // Show page details
    if (isset($params[2]) && $params[2] === "edit" && !empty($params[3])) {
      $this->data['page'] = $adminMn->getPage($params[3]);
      $this->data['blocks'] = $blockMn->getBlocks($params[3]);
    }

    // Ask for available blocks
    if (isset($params[1]) && $params[1] === "get-blocks") {
      $blocks = $blockMn->getApprBlocks();
      // Prepare template for blocks list
      foreach ($blocks as $block)
        echo("<li>${block}</li>");
      exit;
    }

    // Add new block to page
    if (isset($params[1]) && $params[1] === "add-block") {
      $block = json_decode(file_get_contents("php://input"));
      $blockMn->addBlock($block->page, $block->block);
      $blocks = $blockMn->getBlocks($block->page);
      $tempMn->include("group/blocks-group/blocks-group.phtml", '{
        "blocks": ' . json_encode($blocks) . '
      }');
      exit;
    }

    // Delete block and render new blocks group
    if (isset($params[1]) && $params[1] === "delete-block") {
      $block = json_decode(file_get_contents("php://input"));
      $blockMn->deleteBlock($block->id, $block->page);
      $blocks = $blockMn->getBlocks($block->page);
      $tempMn->include("group/blocks-group/blocks-group.phtml", '{
        "blocks": ' . json_encode($blocks) . '
      }');
      exit;
    }

    $this->components = "app/admin/components/";
    $this->view = "admin/main";
  }
}
