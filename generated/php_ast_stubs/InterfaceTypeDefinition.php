<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class InterfaceTypeDefinition extends Definition
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
   * @var FieldDefinition[]
   */
  private $fields;

  public function __construct(
      Location $location,
      Name $name,
      array $directives,
      array $fields
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->directives = $directives;
      $this->fields = $fields;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getFields(): array // FieldDefinition[]
  {
    return $this->fields;
  }
}


