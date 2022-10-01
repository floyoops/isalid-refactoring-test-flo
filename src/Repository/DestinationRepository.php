<?php

namespace App\Repository;

use App\Entity\Destination;
use App\Helper\SingletonTrait;
use Faker\Factory as FakerFactory;

class DestinationRepository implements Repository
{
    use SingletonTrait;

    public function getById(int $id): Destination
    {
        // DO NOT MODIFY THIS METHOD
        $generator    = FakerFactory::create();
        $generator->seed($id);

        return new Destination(
            $id,
            $generator->country,
            'en',
            $generator->slug()
        );
    }
}
