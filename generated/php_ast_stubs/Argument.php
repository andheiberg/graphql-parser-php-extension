<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Argument extends Node
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var Value
   */
  private $value;

  public function __construct(
      Location $location,
      Name $name,
      Value $value
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->value = $value;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getValue(): Value
  {
    return $this->value;
  }
}


