<?php

class AdminController extends Controller {

  public function process(array $params): void
  {
    $adminMn = new AdminManager;

    // Show list of pages
    if (isset($params[1]) && $params[1] === "pages" && empty($params[2])) {
      $this->data['pages'] = $adminMn->getPages();
    }

    // Show page details
    if (isset($params[2]) && $params[2] === "edit" && !empty($params[3])) {
      $this->data['page'] = $adminMn->getPage($params[3]);
    }

    $this->view = "admin";
  }
}
