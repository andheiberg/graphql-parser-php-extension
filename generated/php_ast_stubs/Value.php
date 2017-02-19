<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Value extends Node
{
  public function __construct(
      Location $location
  )
  {
      $this->location = $location;
  }
}

