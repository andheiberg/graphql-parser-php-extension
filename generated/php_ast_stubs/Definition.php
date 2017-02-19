<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Definition extends Node
{
  public function __construct(
      Location $location
  )
  {
      $this->location = $location;
  }
}

