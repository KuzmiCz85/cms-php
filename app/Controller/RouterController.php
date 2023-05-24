<?php
class RouterController extends Controller {

  protected Controller $controller;

  public function process(array $params): void
  {
    $url = $params[0];
    $url = ltrim($url, "/");
    $url = trim($url);

    // Check if user wants to enter administration
    if ($url === "cms") {
      $this->controller = new AdminController;
      $this->controller->process(array($url));
      $this->controller->renderView();
    }

    // Continue to website
    else
      echo "hello to my website";
  }
}
