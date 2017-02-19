<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class OperationTypeDefinition extends Node
{
  /**
   * @var string
   */
  private $operation;

  /**
   * @var NamedType
   */
  private $type;

  public function __construct(
      Location $location,
      string $operation,
      NamedType $type
  )
  {
      $this->location = $location;
      $this->operation = $operation;
      $this->type = $type;
  }

  public function getOperation(): string
  {
    return $this->operation;
  }

  public function getType(): NamedType
  {
    return $this->type;
  }
}


