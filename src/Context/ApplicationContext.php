<?php

namespace App\Context;

use App\Entity\Site;
use App\Entity\User;
use App\Helper\SingletonTrait;
use Faker\Factory as FakerFactory;

class ApplicationContext
{
    use SingletonTrait;

    private Site $currentSite;

    private User $currentUser;

    protected function __construct()
    {
        $faker = FakerFactory::create();
        $this->currentSite = new Site($faker->randomNumber(), $faker->url);
        $this->currentUser = new User($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
    }

    public function getCurrentSite(): Site
    {
        return $this->currentSite;
    }

    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }
}
