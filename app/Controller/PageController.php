<?php

class PageController extends Controller {

  public function process(array $params): void
  {
    $pageMn = new PageManager;

    // Call data for homepage
    if (empty($params[0]) && $pageMn->getHome())
      $this->data['page'] = $pageMn->getHome();

    $this->view = "resources/layout";
  }
}
