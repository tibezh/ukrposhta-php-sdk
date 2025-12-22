<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\EntityCollectionBase;
use Ukrposhta\AddressClassifier\Entities\EntityInterface;

#[CoversClass(EntityCollectionBase::class)]
#[Small]
class EntityCollectionBaseTest extends TestCase
{

    private EntityCollectionBase $collection;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->collection = new class() extends EntityCollectionBase {
            // This class inherits the add and all methods from EntityCollectionBase.
        };
    }

    public function testAddAndAll(): void
    {
        // Define mocks.
        $entityMock1 = $this->createMock(EntityInterface::class);
        $entityMock2 = $this->createMock(EntityInterface::class);

        // Check for empty collection.
        $this->assertEmpty($this->collection->all());

        // Add mock collection items.
        $this->collection->add($entityMock1);
        $this->collection->add($entityMock2);

        // Retrieve all entities and verify their presence.
        $entities = $this->collection->all();
        $this->assertCount(2, $entities);
        $this->assertSame($entityMock1, $entities[0]);
        $this->assertSame($entityMock2, $entities[1]);
    }

    public function testCount(): void
    {
        $this->assertSame(0, $this->collection->count());
        $this->assertCount(0, $this->collection);

        $entityMock1 = $this->createMock(EntityInterface::class);
        $entityMock2 = $this->createMock(EntityInterface::class);

        $this->collection->add($entityMock1);
        $this->assertSame(1, $this->collection->count());
        $this->assertCount(1, $this->collection);

        $this->collection->add($entityMock2);
        $this->assertSame(2, $this->collection->count());
        $this->assertCount(2, $this->collection);
    }

    public function testGetIterator(): void
    {
        $entityMock1 = $this->createMock(EntityInterface::class);
        $entityMock2 = $this->createMock(EntityInterface::class);

        $this->collection->add($entityMock1);
        $this->collection->add($entityMock2);

        $items = [];
        foreach ($this->collection as $key => $item) {
            $items[$key] = $item;
        }

        $this->assertCount(2, $items);
        $this->assertSame($entityMock1, $items[0]);
        $this->assertSame($entityMock2, $items[1]);
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue($this->collection->isEmpty());

        $entityMock = $this->createMock(EntityInterface::class);
        $this->collection->add($entityMock);

        $this->assertFalse($this->collection->isEmpty());
    }

}
