<?php

class AdminController extends Controller {
  public function process(array $params): void
  {
    $adminMn = new AdminManager; // Init admin manager
    $tempMn = new TemplateManager; // Init template manager
    $tempMn->setSource("app/admin/components/");

    // Save new page data
    if (isset($params[1]) && $params[1] === "save") {
      $page = json_decode(file_get_contents("php://input"));
      // Edit page main data
      $adminMn->editPage($page->id, $page->data);
      // Edit page blocks
      if (isset($page->blocks)) $adminMn->editPageBlocks($page->id, $page->blocks);
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

    // Show page details
    if (isset($params[2]) && $params[2] === "edit" && !empty($params[3])) {
      $this->data['page'] = $adminMn->getPage($params[3]);
      $this->data['blocks'] = $adminMn->getPageBlocks($params[3]);
    }

    $this->components = "app/admin/components/";
    $this->view = "admin/main";
  }
}
