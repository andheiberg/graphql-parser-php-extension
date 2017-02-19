# graphql-parser

PHP Extension for Parsing GraphQL Query Language and GraphQL Schema Language. Based off [Facebooks own C parser implemention](https://github.com/graphql/libgraphqlparser).

## Installation

Assumes you've already installed libgraphqlparser on your machine. (`brew install libgraphqlparser` on OSX).

```
# modify INI_DIR in Makefile to be the path to your conf.d can be found using php-config --configure-options
make
make install
```

## Usage

```
<?php

use AndHeiberg\GraphQL\Parser\Parser;

$parser = new Parser();

try {
    $ast = $parser->parse('query { name }');
    print_r($ast);
} catch (\Exception $e) {
    echo sprintf('Parse error: %s', $e->getMessage());
}
```

Output:
```
Array
(
    [kind] => Document
    [loc] => Array
        (
            [start] => 1
            [end] => 15
        )

    [definitions] => Array
        (
            [0] => Array
                (
                    [kind] => OperationDefinition
                    [loc] => Array
                        (
                            [start] => 1
                            [end] => 15
                        )

                    [operation] => query
                    [name] =>
                    [variableDefinitions] =>
                    [directives] =>
                    [selectionSet] => Array
                        (
                            [kind] => SelectionSet
                            [loc] => Array
                                (
                                    [start] => 7
                                    [end] => 15
                                )

                            [selections] => Array
                                (
                                    [0] => Array
                                        (
                                            [kind] => Field
                                            [loc] => Array
                                                (
                                                    [start] => 9
                                                    [end] => 13
                                                )

                                            [alias] =>
                                            [name] => Array
                                                (
                                                    [kind] => Name
                                                    [loc] => Array
                                                        (
                                                            [start] => 9
                                                            [end] => 13
                                                        )

                                                    [value] => name
                                                )

                                            [arguments] =>
                                            [directives] =>
                                            [selectionSet] =>
                                        )

                                )

                        )

                )

        )

)
```

## TODO:
- [ ] Remove modify INI_DIR step from installation
- [ ] [Use custom exceptions instead of \Exception](https://github.com/CopernicaMarketingSoftware/PHP-CPP/issues/315)
- [x] Generate PHP classes in the extension and convert the AST to PHP classes instead of array
- [x] Generate PHP stubs for AST that can be used by IDEs
- [x] Create build script to fetch latest ast.ast from libgraphqlparser