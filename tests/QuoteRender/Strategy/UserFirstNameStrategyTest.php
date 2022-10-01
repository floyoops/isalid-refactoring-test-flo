<?php

namespace Tests\QuoteRender\Strategy;

use App\Context\ApplicationContext;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\UserFirstNameStrategy;
use PHPUnit\Framework\TestCase;

class UserFirstNameStrategyTest extends TestCase
{
    /**
     * @dataProvider provideUserFirstNameStrategy
     */
    public function testUserFirstNameStrategy(string $text, array $data, string $textExpected): void
    {
        $strategy = new UserFirstNameStrategy();
        $text = $strategy->replaceQuote($text, $data);
        self::assertEquals($textExpected, $text);
    }

    public function provideUserFirstNameStrategy(): array
    {
        $templateValid = 'before '.QuoteValue::USER_FIRST_NAME.' after';
        $templateFake = 'before [user::fake] after';
        $expectedUserAppContext = ApplicationContext::getInstance()->getCurrentUser();
        $expectedUserData = StrategyTestData::getUserValid();
        $data = ['user' => $expectedUserData];

        return [
            [$templateFake, [], $templateFake],
            [$templateValid, [], 'before '.$expectedUserAppContext->firstname.' after'],
            [$templateValid, $data, 'before '.$expectedUserData->firstname.' after'],
        ];
    }
}
