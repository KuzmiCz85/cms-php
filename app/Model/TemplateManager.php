<?php
class TemplateManager
{
  protected string $source = "";

  public function setSource($src) : void
  {
    if ($src) $this->source = $src;
  }

  public function include(string $path, string $props = "") : void
  {
    if ($props) {
      $props = json_decode($props);
    } else
      $props = null;

    require($this->source . $path);
  }
}
