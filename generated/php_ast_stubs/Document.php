<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Document extends Node
{
  /**
   * @var Definition[]
   */
  private $definitions;

  public function __construct(
      Location $location,
      array $definitions
  )
  {
      $this->location = $location;
      $this->definitions = $definitions;
  }

  public function getDefinitions(): array // Definition[]
  {
    return $this->definitions;
  }
}


