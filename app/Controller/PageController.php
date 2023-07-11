<?php

class PageController extends Controller {

  public function process(array $params): void
  {
    $pageMn = new PageManager;
    $blockMn = new BlockManager;

    // Call data for homepage
    if (empty($params[0]) && $pageMn->getHome()) {
      $this->data['page'] = $pageMn->getHome();
      $this->data['page']['blocks'] = $blockMn->getBlocks($this->data['page']['id']);
    }

    $this->components= "app/resources/layout/components/";
    $this->view = "resources/layout/components/base-layout/base-layout";
  }
}
