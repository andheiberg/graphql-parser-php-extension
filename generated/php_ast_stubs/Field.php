<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Field extends Selection
{
  /**
   * @var Name
   */
  private $alias;

  /**
   * @var Name
   */
  private $name;

  /**
   * @var Argument[]
   */
  private $arguments;

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
      Name $alias,
      Name $name,
      array $arguments,
      array $directives,
      SelectionSet $selectionSet
  )
  {
      $this->location = $location;
      $this->alias = $alias;
      $this->name = $name;
      $this->arguments = $arguments;
      $this->directives = $directives;
      $this->selectionSet = $selectionSet;
  }

  public function getAlias(): ?Name
  {
    return $this->alias;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getArguments(): ?array // Argument[]
  {
    return $this->arguments;
  }

  public function getDirectives(): ?array // Directive[]
  {
    return $this->directives;
  }

  public function getSelectionSet(): ?SelectionSet
  {
    return $this->selectionSet;
  }
}


