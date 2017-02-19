<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class ObjectValue extends Value
{
  /**
   * @var ObjectField[]
   */
  private $fields;

  public function __construct(
      Location $location,
      array $fields
  )
  {
      $this->location = $location;
      $this->fields = $fields;
  }

  public function getFields(): array // ObjectField[]
  {
    return $this->fields;
  }
}


