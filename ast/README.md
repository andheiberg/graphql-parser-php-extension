# AST.AST parsing
ast.ast is an AST tree of the classes needed to construct an AST tree of a GraphQL query or Schema.

We parse this meta AST to generate PHP classes in the PHP extension and PHP stubs for documentation purposes.

## How to run

Copy latest [ast.ast](https://github.com/graphql/libgraphqlparser/blob/master/ast/ast.ast) into this folder.

I will write a build script that fetches this directly from the libgraphqlparser repo but for now this is the solution.

```
python ast.py php ast.ast
python ast.py php_stub ast.ast
```