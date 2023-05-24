<?php

class AdminController extends Controller {

  public function process(array $params): void
  {
    $this->view = "admin";
  }
}
