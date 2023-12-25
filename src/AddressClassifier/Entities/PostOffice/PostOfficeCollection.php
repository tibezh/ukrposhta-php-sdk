<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

/**
 *
 */
class PostOfficeCollection implements PostOfficeCollectionInterface
{

  /**
   * Simple array of Post Office objects.
   *
   * @var array<int, PostOfficeInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(PostOfficeInterface $postOffice): void
  {
    $this->items[] = $postOffice;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
