<?php

use G4\DataMapper\Engine\MySQL\MySQLAdapter;

class MySQLAdapterTest extends PHPUnit_Framework_TestCase
{

    private $adapter;

    private $clientStub;


    protected function setUp()
    {
        $this->adapter = new MySQLAdapter($this->getMockForMySQLClientFactory());
    }

    protected function tearDown()
    {
        $this->adapter = null;
        $this->clientStub = null;
    }

    public function testDelete()
    {
        $this->clientStub->expects($this->once())
            ->method('delete');

        $mappingsStub = $this->getMockForMappings();
        $mappingsStub
            ->expects($this->once())
            ->method('identifiers')
            ->willReturn(['id' => 1]);

        $this->adapter->delete('data', $mappingsStub);
    }

    public function testEmptyDataForDelete()
    {
        $this->clientStub->expects($this->never())
            ->method('delete');

        $mappingsStub = $this->getMockForMappings();
        $mappingsStub
            ->expects($this->once())
            ->method('identifiers')
            ->willReturn([]);

        $this->setExpectedException('\Exception', 'Empty identifiers for delete');
        $this->adapter->delete('data', $mappingsStub);
    }

    public function testEmptyDataForInsert()
    {
        $this->clientStub->expects($this->never())
            ->method('insert');

        $mappingsStub = $this->getMockForMappings();
        $mappingsStub
            ->expects($this->once())
            ->method('map')
            ->willReturn([]);

        $this->setExpectedException('\Exception', 'Empty data for insert');
        $this->adapter->insert('data', $mappingsStub);
    }

    public function testEmptyDataForUpdate()
    {
        $this->clientStub->expects($this->never())
            ->method('update');
        $this->setExpectedException('\Exception', 'Empty data for update');
        $this->adapter->update('data', [], []);
        $this->setExpectedException('\Exception', 'Empty identifiers for update');
        $this->adapter->update('data', ['id' => 1], []);
    }

    public function testInsert()
    {
        $this->clientStub->expects($this->once())
            ->method('insert');

        $mappingsStub = $this->getMockForMappings();
        $mappingsStub
            ->expects($this->once())
            ->method('map')
            ->willReturn(['id' => 1]);

        $this->adapter->insert('data', $mappingsStub);
    }

    public function testUpdate()
    {
        $this->clientStub->expects($this->once())
            ->method('update');
        $this->adapter->update('data', ['ts' => 123], ['id' => 1]);
    }

    private function getMockForMySQLClientFactory()
    {
        $this->clientStub = $this->getMockBuilder('\Zend_Db_Adapter_Mysqli')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'delete', 'update'])
            ->getMock();

        $clientFactoryStub = $this->getMockBuilder('\G4\DataMapper\Engine\MySQL\MySQLClientFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $clientFactoryStub->method('create')
            ->willReturn($this->clientStub);

        return $clientFactoryStub;
    }

    private function getMockForMappings()
    {
        $mappingsStub = $this->getMockBuilder('\G4\DataMapper\Common\MappingInterface')
            ->getMock();
        return $mappingsStub;
    }
}