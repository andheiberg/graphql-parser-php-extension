<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class EnumTypeDefinition extends Definition
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
   * @var EnumValueDefinition[]
   */
  private $values;

  public function __construct(
      Location $location,
      Name $name,
      array $directives,
      array $values
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->directives = $directives;
      $this->values = $values;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getValues(): array // EnumValueDefinition[]
  {
    return $this->values;
  }
}


