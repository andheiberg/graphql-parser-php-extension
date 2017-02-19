<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class ListType extends Type
{
  /**
   * @var Type
   */
  private $type;

  public function __construct(
      Location $location,
      Type $type
  )
  {
      $this->location = $location;
      $this->type = $type;
  }

  public function getType(): Type
  {
    return $this->type;
  }
}


