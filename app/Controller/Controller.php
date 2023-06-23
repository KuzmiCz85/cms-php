<?php
abstract class Controller {

  protected array $data = array();
  protected string $view = "";
  protected string $components = "";

  abstract function process(array $params): void;

  public function renderView(): void
  {
    // Template components manager
    $tempMn = new TemplateManager; // Init manager
    if ($this->components)
        $tempMn->setSource($this->components); // Set specific templates source

    // Main view
    if ($this->view) {
      extract($this->data); // Extract data for view from array
      require("./app/" . $this->view . ".phtml"); // Require view
    }
  }
}
