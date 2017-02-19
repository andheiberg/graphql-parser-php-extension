<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class OperationDefinition extends Definition
{
  /**
   * @var string
   */
  private $operation;

  /**
   * @var Name
   */
  private $name;

  /**
   * @var VariableDefinition[]
   */
  private $variableDefinitions;

  /**
   * @var Directive[]
   */
  private $directives;

  /**
   * @var SelectionSet
   */
  private $selectionSet;

  public function __construct(
      Location $location,
      string $operation,
      Name $name,
      array $variableDefinitions,
      array $directives,
      SelectionSet $selectionSet
  )
  {
      $this->location = $location;
      $this->operation = $operation;
      $this->name = $name;
      $this->variableDefinitions = $variableDefinitions;
      $this->directives = $directives;
      $this->selectionSet = $selectionSet;
  }

  public function getOperation(): string
  {
    return $this->operation;
  }

  public function getName(): ?Name
  {
    return $this->name;
  }

  public function getVariabledefinitions(): ?array // VariableDefinition[]
  {
    return $this->variableDefinitions;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getSelectionset(): SelectionSet
  {
    return $this->selectionSet;
  }
}


