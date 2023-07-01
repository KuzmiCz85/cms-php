<?php
class TemplateManager
{
  protected string $source = "";
  protected $tempMn;

  public function setSource($src) : void
  {
    if ($src) $this->source = $src;
  }

  public function include(string $path, string $data = "") : void
  {
    if ($data) $data = json_decode($data);
    else $data = null;

    // Create instance of template manager for components nesting
    $tempMn = new TemplateManager;
    $tempMn->setSource($this->source);

    require($this->source . $path);
  }
}
