<?php

namespace Tests\QuoteRender\Strategy;

use App\Entity\Quote;
use App\Entity\User;
use Faker\Factory as FakerFactory;

class StrategyTestData
{
    public static function getQuoteValid(): Quote
    {
        $faker = FakerFactory::create();

        return new Quote(
            $faker->randomNumber(),
            $faker->randomNumber(),
            $faker->randomNumber(),
            $faker->dateTime
        );
    }

    public static function getUserValid(): User
    {
        $faker = FakerFactory::create();

        return new User(
            $faker->randomNumber(),
            $faker->firstName(),
            $faker->lastName(),
            $faker->email()
        );
    }
}
