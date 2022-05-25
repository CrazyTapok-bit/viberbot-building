<?php

namespace Viberbot\Building\Router;

class Result
{
  private $handler;
  private $event;

  public function __construct($handler, $event)
  {
    $this->handler = $handler;
    $this->event = $event;
  }

  public function getHandler()
  {
    return $this->handler;
  }

  public function getEvent()
  {
    return $this->event;
  }
}
