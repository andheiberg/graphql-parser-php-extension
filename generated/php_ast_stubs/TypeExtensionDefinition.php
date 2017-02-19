<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class TypeExtensionDefinition extends Definition
{
  /**
   * @var ObjectTypeDefinition
   */
  private $definition;

  public function __construct(
      Location $location,
      ObjectTypeDefinition $definition
  )
  {
      $this->location = $location;
      $this->definition = $definition;
  }

  public function getDefinition(): ObjectTypeDefinition
  {
    return $this->definition;
  }
}


