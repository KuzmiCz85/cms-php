<?php
class TemplateManager
{
  protected string $source = "";

  public function setSource($src) : void
  {
    if ($src) $this->source = $src;
  }

  public function include(string $path, string $data = "") : void
  {
    if ($data) $data = json_decode($data);
    else $data = null;

    require($this->source . $path);
  }
}
