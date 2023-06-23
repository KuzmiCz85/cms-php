<?php
class TemplateManager
{
  public function include(string $path, string $props = "") : void
  {
    if ($props) {
      $props = json_decode($props);
    } else
      $props = null;

    require("app/admin/components/" . $path);
  }
}
