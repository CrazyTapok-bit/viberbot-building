<?php

namespace Viberbot\Building;

use Viberbot\Building\Pipeline\Pipeline;
use Viberbot\Building\Router\Resolver;
use Viberbot\Building\Router\RouteCollection;
use Viberbot\Building\Router\Router;
use Viberbot\Messages\Event\Event;

class Bot extends Pipeline
{
  private $data;
  private $resolver;
  private $router;
  private $default;

  public function __construct($default)
  {
    parent::__construct();
    $this->resolver = new Resolver();
    $this->router = new RouteCollection();
    $this->default = $default;
  }

  public function pipe($middleware): void
  {
    parent::pipe($this->resolver->resolve($middleware));
  }

  public function onConversation($handler): void
  {
    $this->router->onConversation($handler);
  }

  public function onSubscribe($handler): void
  {
    $this->router->onSubscribe($handler);
  }

  public function onUnsubscribe($handler): void
  {
    $this->router->onUnsubscribe($handler);
  }

  public function onMessage($handler): void
  {
    $this->router->onMessage($handler);
  }

  public function onDelivered($handler): void
  {
    $this->router->onDelivered($handler);
  }

  public function onSeen($handler): void
  {
    $this->router->onSeen($handler);
  }

  public function onFailed($handler): void
  {
    $this->router->onFailed($handler);
  }

  private function getInputBody()
  {
      return file_get_contents('php://input');
  }

  public function run($event = null)
  {
    $this->data = json_decode($event ?: $this->getInputBody());

    $router = new Router($this->router);
    $result = $router->match(new Event($this->data));
    $this->pipe($result->getHandler());
    $event = $result->getEvent();
    $default = is_string($this->default) ? new $this->default : $this->default;
    $this(new $event($this->data), $default);
  }
}
