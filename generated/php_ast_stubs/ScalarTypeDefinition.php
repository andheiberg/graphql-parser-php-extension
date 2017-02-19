<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class ScalarTypeDefinition extends Definition
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var Directive[]
   */
  private $directives;

  public function __construct(
      Location $location,
      Name $name,
      array $directives
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->directives = $directives;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }
}


