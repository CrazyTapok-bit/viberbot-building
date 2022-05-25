<?php

namespace Viberbot\Building\Router;

use Viberbot\Messages\Event\Event;

class Route
{
  public $name;
  public $handler;
  public $event;

  public function __construct(string $name, $handler, $event)
  {
    $this->name = $name;
    $this->handler = $handler;
    $this->event = $event;
  }

  public function match(Event $event): ?bool
  {
    return $event->getEvent() === $this->name;
  }
}
