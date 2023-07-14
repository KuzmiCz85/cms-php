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
    }

    // Url slug contains only single page
    elseif (isset($params[0])) {
      $page = $pageMn->getPage($params[0]);

      if ($page && $page['status'] === "publish") { // Page exists and has been published
        $this->data['page'] = $pageMn->getPage($params[0]);
        $this->data['page']['blocks'] = $blockMn->getBlocks($this->data['page']['id']);
      }

      else { // Page doesn't exist
        $this->data['page'] = $pageMn->get404(); // Set page as 404
      }
    }

    $this->data['page']['menu']['items'] = $menuMn->getItems();

    $this->components= "app/resources/layout/components/";
    $this->view = "resources/layout/components/layout-base/layout-base";
  }
}
