<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class NullValue extends Value
{
  public function __construct(
      Location $location
  )
  {
      $this->location = $location;
  }

}


