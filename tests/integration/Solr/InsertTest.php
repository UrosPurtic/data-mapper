<?php

namespace G4\DataMapper\Test\Integration\Solr;

class InsertTest extends TestCase
{
    public function testInsert()
    {
        $this->makeMapper()->insert($this->makeMapping());

        $rawData = $this->makeMapper()->find($this->makeIdentityById());

        $this->assertEquals(1, $rawData->count());
        $this->assertArraySubset($this->getData(), $rawData->getOne());
    }

    public function getCollectionName()
    {
        return 'nd_api_messages';
    }
}
