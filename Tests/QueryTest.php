<?php

namespace AndHeiberg\GraphQL\Parser\Tests;

use AndHeiberg\GraphQL\Parser\Parser;
use AndHeiberg\GraphQL\Parser\AST\OperationDefinition;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testMini()
    {
        $parser = new Parser();
        $ast = $parser->parse('
query queryName($foo: ComplexType, $site: Site = MOBILE) {
  whoever123is: node(id: [123, 456]) {
    id ,
    ... on User @defer {
      field2 {
        id ,
        alias: field1(first:10, after:$foo,) @include(if: $foo) {
          id,
          ...frag
        }
      }
    }
    ... @skip(unless: $foo) {
      id
    }
    ... {
      id
    }
  }
}');

        // Root AST should always be Document
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\Document',
            $ast
        );

        // Definitions is an array
        // In this case containing 5 definintions.
        // (named query, mutation, subscription, fragment and unamed query)
        $this->assertEquals(1, count($ast->getDefinitions()));
        
        var_dump($ast->getDefinitions()[0]->getSelectionSet()->getSelections()[0]);

        $this->assertQueryIsWellFormedBeta($ast->getDefinitions()[0]);
    }

    private function assertQueryIsWellFormedBeta(OperationDefinition $query)
    {
        $this->assertEquals(
            'query',
            $query->getOperation()
        );

        // $this->assertEquals(
        //     'queryName',
        //     $query->getName()->getValue()
        // );

        $this->assertEquals(2, count($query->getVariabledefinitions()));

        $fooVar = $query->getVariabledefinitions()[0];
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\VariableDefinition',
            $fooVar
        );

        $this->assertEquals(
            'foo',
            $fooVar->getVariable()->getName()->getValue()
        );

        $this->assertEquals(
            'ComplexType',
            $fooVar->getType()->getName()->getValue()
        );

        $siteVar = $query->getVariabledefinitions()[1];
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\VariableDefinition',
            $siteVar
        );

        $this->assertEquals(
            'Site',
            $siteVar->getType()->getName()->getValue()
        );

        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\EnumValue',
            $siteVar->getDefaultValue()
        );
        $this->assertEquals(
            'MOBILE',
            $siteVar->getDefaultValue()->getValue()
        );

        $fields = $query->getSelectionSet()->getSelections();
        $this->assertEquals(1, count($fields));

        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\Field',
            $fields[0]
        );
        $this->assertEquals(
            'id',
            $fields[0]->getName()->getValue()
        );
    }

//     public function testSuperSimpleQuery()
//     {
//         $parser = new Parser();
//         $ast = $parser->parse('
// query queryName($foo: ComplexType, $site: Site = MOBILE) {
//   whoever123is: node(id: [123, 456]) {
//     id ,
//     ... on User @defer {
//       field2 {
//         id ,
//         alias: field1(first:10, after:$foo,) @include(if: $foo) {
//           id,
//           ...frag
//         }
//       }
//     }
//     ... @skip(unless: $foo) {
//       id
//     }
//     ... {
//       id
//     }
//   }
// }

// mutation likeStory {
//   like(story: 123) @defer {
//     story {
//       id
//     }
//   }
// }

// subscription StoryLikeSubscription($input: StoryLikeSubscribeInput) {
//   storyLikeSubscribe(input: $input) {
//     story {
//       likers {
//         count
//       }
//       likeSentence {
//         text
//       }
//     }
//   }
// }

// fragment frag on Friend {
//   foo(size: $size, bar: $b, obj: {key: "value"})
// }

// {
//   unnamed(truthy: true, falsey: false, nullish: null),
//   query
// }');

//         // Root AST should always be Document
//         $this->assertInstanceOf(
//             'AndHeiberg\GraphQL\Parser\AST\Document',
//             $ast
//         );

//         // Definitions is an array
//         $this->assertTrue(
//             is_array($ast->getDefinitions())
//         );
//         // In this case containing 5 definintions.
//         // (named query, mutation, subscription, fragment and unamed query)
//         $this->assertEquals(5, count($ast->getDefinitions()));
        
//         $this->assertQueryIsWellFormed($ast->getDefinitions()[0]);
//     }

    private function assertQueryIsWellFormed(OperationDefinition $query)
    {
        // $this->assertEquals(
        //     'queryName',
        //     $query->getName()->getValue()
        // );

        var_dump($query->getVariabledefinitions()[0]->getVariable());
        $this->assertEquals(2, count($query->getVariabledefinitions()));

        $fooVar = $query->getVariabledefinitions()[0];
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\VariableDefinition',
            $fooVar
        );

        // $this->assertEquals(
        //     'foo',
        //     $fooVar->getVariable()->getName()->getValue()
        // );

        $this->assertEquals(
            'ComplexType',
            $fooVar->getType()->getName()->getValue()
        );
        
        // $this->assertTrue(
        //     is_array($ast->getDefinitions()[0]->getSelectionSet()->getSelections())
        // );
        // $this->assertEquals(1, count($ast->getDefinitions()[0]->getSelectionSet()->getSelections()));

        // $aField = $ast->getDefinitions()[0]->getSelectionset()->getSelections()[0];
        // $this->assertInstanceOf(
        //     'AndHeiberg\GraphQL\Parser\AST\Field',
        //     $aField
        // );
        // $this->assertEquals(
        //     'a',
        //     $aField->getName()->getValue()
        // );
        // $this->assertInstanceOf(
        //     'AndHeiberg\GraphQL\Parser\AST\SelectionSet',
        //     $aField->getSelectionSet()
        // );

        // $this->assertTrue(
        //     is_array($aField->getSelectionSet()->getSelections())
        // );
        // $this->assertEquals(1, count($aField->getSelectionSet()->getSelections()));

        // $bField = $aField->getSelectionSet()->getSelections()[0];
        // $this->assertInstanceOf(
        //     'AndHeiberg\GraphQL\Parser\AST\Field',
        //     $bField
        // );
        // $this->assertEquals(
        //     'b',
        //     $bField->getName()->getValue()
        // );
     }
}
