<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class Directive extends Node
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var Argument[]
   */
  private $arguments;

  public function __construct(
      Location $location,
      Name $name,
      array $arguments
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->arguments = $arguments;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getArguments(): ?array // Argument[]
  {
    return $this->arguments;
  }
}


