<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

trait FakerGeneratorTrait
{
    protected ?FakerGeneratorInterface $fakerGenerator = null;

    protected function fakerGenerator(): FakerGeneratorInterface
    {
        if (!$this->fakerGenerator) {
            $this->fakerGenerator = FakerFactory::createCustom();
        }

        return $this->fakerGenerator;
    }
}
