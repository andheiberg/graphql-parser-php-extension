<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class InlineFragment extends Selection
{
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
      NamedType $typeCondition,
      array $directives,
      SelectionSet $selectionSet
  )
  {
      $this->location = $location;
      $this->typeCondition = $typeCondition;
      $this->directives = $directives;
      $this->selectionSet = $selectionSet;
  }

  public function getTypeCondition(): ?NamedType
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


