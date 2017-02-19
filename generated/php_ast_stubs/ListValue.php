<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class ListValue extends Value
{
  /**
   * @var Value[]
   */
  private $values;

  public function __construct(
      Location $location,
      array $values
  )
  {
      $this->location = $location;
      $this->values = $values;
  }

  public function getValues(): array // Value[]
  {
    return $this->values;
  }
}


