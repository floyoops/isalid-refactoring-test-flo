<?php

namespace Tests\QuoteRender\Strategy;

use App\Entity\Quote;
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
}
