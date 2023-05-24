<?php
abstract class Controller {

  protected array $data = array();
  protected string $view = "";

  abstract function process(array $params): void;

  public function renderView(): void
  {
    if ($this->view) {
      extract($this->data);
      require("./app/View/" . $this->view . ".phtml");
    }
  }
}
