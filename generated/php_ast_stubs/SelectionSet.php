<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class SelectionSet extends Node
{
  /**
   * @var Selection[]
   */
  private $selections;

  public function __construct(
      Location $location,
      array $selections
  )
  {
      $this->location = $location;
      $this->selections = $selections;
  }

  public function getSelections(): array // Selection[]
  {
    return $this->selections;
  }
}


