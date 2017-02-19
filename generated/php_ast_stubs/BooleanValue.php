<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class BooleanValue extends Value
{
  /**
   * @var bool
   */
  private $value;

  public function __construct(
      Location $location,
      bool $value
  )
  {
      $this->location = $location;
      $this->value = $value;
  }

  public function getValue(): bool
  {
    return $this->value;
  }
}


