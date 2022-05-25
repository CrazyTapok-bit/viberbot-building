<?php

namespace Viberbot\Building\Pipeline;

use SplQueue;

class Pipeline
{
  private $queue;

  public function __construct()
  {
    $this->queue = new SplQueue();
  }

  public function __invoke($event, callable $next)
  {
    $delegate = new Next($this->queue, $next);
    return $delegate($event);
  }

  public function pipe($middleware): void
  {
    $this->queue->enqueue($middleware);
  }
}
