<?php

class PageController extends Controller {

  public function process(array $params): void
  {
    $blockMn = new BlockManager;
    $menuMn = new MenuManager;
    $pageMn = new PageManager;

    // Call data for homepage
    if (empty($params[0]) && $pageMn->getHome()) {
      $this->data['page'] = $pageMn->getHome();
      $this->data['page']['blocks'] = $blockMn->getBlocks($this->data['page']['id']);
      $this->data['page']['menu']['items'] = $menuMn->getItems();
    }

    $this->components= "app/resources/layout/components/";
    $this->view = "resources/layout/components/layout-base/layout-base";
  }
}
