<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class NamedType extends Type
{
  /**
   * @var Name
   */
  private $name;

  public function __construct(
      Location $location,
      Name $name
  )
  {
      $this->location = $location;
      $this->name = $name;
  }

  public function getName(): Name
  {
    return $this->name;
  }
}


