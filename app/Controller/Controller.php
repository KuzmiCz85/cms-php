<?php
abstract class Controller {

  protected array $data = array();
  protected string $view = "";

  abstract function process(array $params): void;

  public function renderView(): void
  {
    if ($this->view) {
      // Init template component manager
      $tempMn = new TemplateManager;
      // Extract data for view
      extract($this->data);
      // Require view
      require("./app/" . $this->view . ".phtml");
    }
  }
}
