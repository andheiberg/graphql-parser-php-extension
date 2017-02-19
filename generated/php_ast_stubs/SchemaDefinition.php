<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class SchemaDefinition extends Definition
{
  /**
   * @var Directive[]
   */
  private $directives;

  /**
   * @var OperationTypeDefinition[]
   */
  private $operationTypes;

  public function __construct(
      Location $location,
      array $directives,
      array $operationTypes
  )
  {
      $this->location = $location;
      $this->directives = $directives;
      $this->operationTypes = $operationTypes;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getOperationtypes(): array // OperationTypeDefinition[]
  {
    return $this->operationTypes;
  }
}


