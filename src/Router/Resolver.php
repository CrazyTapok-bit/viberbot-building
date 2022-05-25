<?php

namespace Viberbot\Building\Router;

use Viberbot\Building\Pipeline\Pipeline;
use Viberbot\Messages\Event\Event;

class Resolver
{
  public function resolve($handler): callable
  {

    if(is_array($handler)){
      return $this->createPipe($handler);
    }

    if(is_string($handler)){
      return function (Event $event, callable $next) use($handler){
        $obj = new $handler();
        return $obj($event, $next);
      };
    }

    return $handler;
  }

  private function createPipe(array $handlers): Pipeline
  {
    $pipeline = new Pipeline();

    foreach($handlers as $handler){
      $pipeline->pipe($this->resolve($handler));
    }

    return $pipeline;
  }
}
