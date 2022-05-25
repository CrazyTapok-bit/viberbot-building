<?php

namespace Viberbot\Building\Pipeline;

use SplQueue;

class Next
{
  private $queue;

  private $next;

  public function __construct(SplQueue $queue, $next)
  {
    $this->queue = $queue;
    $this->next = $next;
  }

  public function __invoke($event)
  {
    if($this->queue->isEmpty()){
      return ($this->next)($event);
    }

    $current = $this->queue->dequeue();

    return $current($event, function($event){
      return $this($event);
    });
  }
}
