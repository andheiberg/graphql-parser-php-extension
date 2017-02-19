<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class UnionTypeDefinition extends Definition
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var Directive[]
   */
  private $directives;

  /**
   * @var NamedType[]
   */
  private $types;

  public function __construct(
      Location $location,
      Name $name,
      array $directives,
      array $types
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->directives = $directives;
      $this->types = $types;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getTypes(): array // NamedType[]
  {
    return $this->types;
  }
}


