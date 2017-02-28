<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class InputValueDefinition extends Node
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var Type
   */
  private $type;

  /**
   * @var Value
   */
  private $defaultValue;

  /**
   * @var Directive[]
   */
  private $directives;

  public function __construct(
      Location $location,
      Name $name,
      Type $type,
      Value $defaultValue,
      array $directives
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->type = $type;
      $this->defaultValue = $defaultValue;
      $this->directives = $directives;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getType(): Type
  {
    return $this->type;
  }

  public function getDefaultValue(): ?Value
  {
    return $this->defaultValue;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }
}


