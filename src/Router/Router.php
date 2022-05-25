<?php

namespace Viberbot\Building\Router;

use Viberbot\Messages\Event\Event;

class Router
{
  private $routes;

  public function __construct(RouteCollection $routes)
  {
    $this->routes = $routes;
  }

  public function match(Event $event): Result
  {
    foreach($this->routes->getRoutes() as $route){
      if($route->match($event)){
        return new Result($route->handler, $route->event);
      }
    }

    throw new \LogicException('Matches not found.');
  }
}
