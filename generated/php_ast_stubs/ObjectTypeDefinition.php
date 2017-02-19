<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class ObjectTypeDefinition extends Definition
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var NamedType[]
   */
  private $interfaces;

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
      array $interfaces,
      array $directives,
      array $fields
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->interfaces = $interfaces;
      $this->directives = $directives;
      $this->fields = $fields;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getInterfaces(): ?array // NamedType[]
  {
    return $this->interfaces;
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


