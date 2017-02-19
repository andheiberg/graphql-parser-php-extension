<?php

namespace AndHeiberg\GraphQL\Parser\AST;

class DirectiveDefinition extends Definition
{
  /**
   * @var Name
   */
  private $name;

  /**
   * @var InputValueDefinition[]
   */
  private $arguments;

  /**
   * @var Name[]
   */
  private $locations;

  public function __construct(
      Location $location,
      Name $name,
      array $arguments,
      array $locations
  )
  {
      $this->location = $location;
      $this->name = $name;
      $this->arguments = $arguments;
      $this->locations = $locations;
  }

  public function getName(): Name
  {
    return $this->name;
  }

  public function getArguments(): ?array // InputValueDefinition[]
  {
    return $this->arguments;
  }

  public function getLocations(): array // Name[]
  {
    return $this->locations;
  }
}


