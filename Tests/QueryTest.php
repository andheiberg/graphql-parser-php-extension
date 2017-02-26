<?php

namespace AndHeiberg\GraphQL\Parser\Tests;

use AndHeiberg\GraphQL\Parser\Parser;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testSuperSimpleQuery()
    {
        $parser = new Parser();
        $ast = $parser->parse("{
            a {
                b
            }
        }");

        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\Document',
            $ast
        );

        $this->assertTrue(
            is_array($ast->getDefinitions())
        );
        $this->assertEquals(1, count($ast->getDefinitions()));
        
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\OperationDefinition',
            $ast->getDefinitions()[0]
        );
        
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\SelectionSet',
            $ast->getDefinitions()[0]->getSelectionSet()
        );
        
        $this->assertTrue(
            is_array($ast->getDefinitions()[0]->getSelectionSet()->getSelections())
        );
        $this->assertEquals(1, count($ast->getDefinitions()[0]->getSelectionSet()->getSelections()));

        $aField = $ast->getDefinitions()[0]->getSelectionset()->getSelections()[0];
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\Field',
            $aField
        );
        $this->assertEquals(
            'a',
            $aField->getName()->getValue()
        );
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\SelectionSet',
            $aField->getSelectionSet()
        );

        $this->assertTrue(
            is_array($aField->getSelectionSet()->getSelections())
        );
        $this->assertEquals(1, count($aField->getSelectionSet()->getSelections()));

        $bField = $aField->getSelectionSet()->getSelections()[0];
        $this->assertInstanceOf(
            'AndHeiberg\GraphQL\Parser\AST\Field',
            $bField
        );
        $this->assertEquals(
            'b',
            $bField->getName()->getValue()
        );
    }
}
