<?php

namespace Viberbot\Building\Router;

use Viberbot\Messages\Event\Conversation;
use Viberbot\Messages\Event\Delivered;
use Viberbot\Messages\Event\Failed;
use Viberbot\Messages\Event\Message;
use Viberbot\Messages\Event\Seen;
use Viberbot\Messages\Event\Subscribed;
use Viberbot\Messages\Event\Type;
use Viberbot\Messages\Event\Unsubscribed;

class RouteCollection
{
  private $routes = [];

  private function addRoute(string $type, $handler, $event)
  {
    $this->routes[] = new Route($type, $handler, $event);
  }

  public function onConversation($handler): void
  {
    $this->addRoute(Type::CONVERSATION, $handler, Conversation::class);
  }

  public function onSubscribe($handler): void
  {
    $this->addRoute(Type::SUBSCRIBED, $handler, Subscribed::class);
  }

  public function onUnsubscribe($handler): void
  {
    $this->addRoute(Type::UNSUBSCRIBED, $handler, Unsubscribed::class);
  }

  public function onMessage($handler): void
  {
    $this->addRoute(Type::MESSAGE, $handler, Message::class);
  }

  public function onDelivered($handler): void
  {
    $this->addRoute(Type::DELIVERED, $handler, Delivered::class);
  }

  public function onSeen($handler): void
  {
    $this->addRoute(Type::SEEN, $handler, Seen::class);
  }

  public function onFailed($handler): void
  {
    $this->addRoute(Type::FAILED, $handler, Failed::class);
  }

  /**
   * @return Route[]
   */
  public function getRoutes(): array
  {
    return $this->routes;
  }
}
