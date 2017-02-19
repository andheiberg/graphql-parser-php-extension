<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class FieldDefinition extends Node
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var InputValueDefinition[]
   */
  private $arguments;

  /**
   * @var Type
   */
  private $type;

  /**
   * @var Directive[]
   */
  private $directives;

  public function __construct(
      Location $location,
      Name $name,
      array $arguments,
      Type $type,
      array $directives
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->arguments = $arguments;
      $this->type = $type;
      $this->directives = $directives;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getArguments(): ?array // InputValueDefinition[]
  {
    return $this->arguments;
  }

  public function getType(): Type
  {
    return $this->type;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }
}


