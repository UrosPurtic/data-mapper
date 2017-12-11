<?php

use G4\DataMapper\Engine\Solr\SolrComparisonFormatter;
use G4\DataMapper\Common\Selection\Operator;

class SolrComparisonFormatterTest extends PHPUnit_Framework_TestCase
{

    private $comparisonFormatter;

    private $operatorMock;

    protected function setUp()
    {
        $this->comparisonFormatter = new SolrComparisonFormatter();

        $this->operatorMock = $this->getMockBuilder('\G4\DataMapper\Common\Selection\Operator')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->comparisonFormatter = null;
        $this->operatorMock        = null;
    }

    public function testEqual()
    {
        $this->operatorMock->expects($this->once())
            ->method('getSymbol')
            ->willReturn(Operator::EQUAL);

        $this->assertEquals('name:test', $this->comparisonFormatter->format('name', $this->operatorMock, 'test'));
    }
}
