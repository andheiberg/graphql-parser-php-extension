<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Selection extends Node
{
  public function __construct(
      Location $location
  )
  {
      $this->location = $location;
  }
}

