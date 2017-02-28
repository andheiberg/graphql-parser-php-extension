# graphql-parser

PHP Extension for Parsing GraphQL Query Language and GraphQL Schema Language. Based off [Facebooks own C parser implemention](https://github.com/graphql/libgraphqlparser).

## Requirements

- PHP 7+ (`brew install php70` or `brew install php71`)
- [libgraphqlparser](https://github.com/graphql/libgraphqlparser) (`brew install libgraphqlparser`)
- [PHP-CPP](http://www.php-cpp.com/documentation/install)

## Installation

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
} catch (\Exception $e) {
    echo sprintf('Parse error: %s', $e->getMessage());
}
```

`Parser::parse()` will be a `AndHeiberg\GraphQL\Parser\AST\Document` or a `AndHeiberg\GraphQL\Parser\AST\SchemaDefinition` object. Have a look at [the php stub files](https://github.com/AndreasHeiberg/graphql-parser-php-extension/tree/master/generated/php_ast_stubs) to get an understanding of the AST structure.

The files can also be dropped into your IDE to allow auto-complete.

## TODO:
- [ ] Remove modify INI_DIR step from installation
- [ ] [Use custom exceptions instead of \Exception](https://github.com/CopernicaMarketingSoftware/PHP-CPP/issues/315)
- [x] Generate PHP classes in the extension and convert the AST to PHP classes instead of array
- [x] Generate PHP stubs for AST that can be used by IDEs
- [x] Create build script to fetch latest ast.ast from libgraphqlparser