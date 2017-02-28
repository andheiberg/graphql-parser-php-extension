<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class FragmentDefinition extends Definition
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var NamedType
   */
  private $typeCondition;

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
      Name $name,
      NamedType $typeCondition,
      array $directives,
      SelectionSet $selectionSet
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->typeCondition = $typeCondition;
      $this->directives = $directives;
      $this->selectionSet = $selectionSet;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getTypeCondition(): NamedType
  {
    return $this->typeCondition;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getSelectionSet(): SelectionSet
  {
    return $this->selectionSet;
  }
}


