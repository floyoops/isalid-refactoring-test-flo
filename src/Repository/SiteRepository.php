<?php

namespace App\Repository;

use App\Entity\Site;
use App\Helper\SingletonTrait;
use Faker\Factory as FakerFactory;

class SiteRepository implements Repository
{
    use SingletonTrait;

    private $url;

    public function getById(int $id): Site
    {
        // DO NOT MODIFY THIS METHOD
        $generator = FakerFactory::create();
        $generator->seed($id);

        return new Site($id, $generator->url);
    }
}
