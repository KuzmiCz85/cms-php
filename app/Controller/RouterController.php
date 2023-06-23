<?php
class RouterController extends Controller {

  protected Controller $controller;

  // Proces url to array of parameters
  private function processUrl(string $url): array
  {
    $parsedUrl = parse_url($url);
    $parsedUrl['path'] = ltrim($parsedUrl['path'], "/");
    $parsedUrl['path'] = trim($parsedUrl['path']);

    $params = explode("/", $parsedUrl['path']);

    var_dump($params);

    return $params;
  }

  public function process(array $params): void
  {
    $parsedUrl = $this->processUrl($params[0]);

    // Check if user wants to enter administration
    if ($parsedUrl[0] === "cms") {
      $this->controller = new AdminController;
      $this->controller->process($parsedUrl);
      $this->controller->renderView();
    }

    // Continue to website
    else {
      $this->controller = new PageController;
      $this->controller->process($parsedUrl);
      $this->controller->renderView();
    }
  }
}
