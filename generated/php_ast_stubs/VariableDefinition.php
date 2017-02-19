<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class VariableDefinition extends Node
{
  /**
   * @var Variable
   */
  private $variable;

  /**
   * @var Type
   */
  private $type;

  /**
   * @var Value
   */
  private $defaultValue;

  public function __construct(
      Location $location,
      Variable $variable,
      Type $type,
      Value $defaultValue
  )
  {
      $this->location = $location;
      $this->variable = $variable;
      $this->type = $type;
      $this->defaultValue = $defaultValue;
  }

  public function getVariable(): Variable
  {
    return $this->variable;
  }

  public function getType(): Type
  {
    return $this->type;
  }

  public function getDefaultvalue(): ?Value
  {
    return $this->defaultValue;
  }
}


