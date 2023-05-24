<?php
class AdminManager
{
  public function getPages(): array
  {
    return Db::queryAll("
      SELECT name
      FROM page
    ");
  }
}
