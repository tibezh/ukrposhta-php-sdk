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

}
