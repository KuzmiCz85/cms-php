<?php

class AdminController extends Controller {

  public function process(array $params): void
  {
    $adminMn = new AdminManager;

    if (isset($params[1]) && $params[1] === "pages") {
      $this->data['pages'] = $adminMn->getPages();
    }

    $this->view = "admin";
  }
}
