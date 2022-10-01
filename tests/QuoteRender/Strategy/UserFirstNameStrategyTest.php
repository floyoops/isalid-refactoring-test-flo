<?php

namespace Tests\QuoteRender\Strategy;

use App\Context\ApplicationContext;
use App\QuoteRender\QuoteDto;
use App\QuoteRender\QuoteValue;
use App\QuoteRender\Strategy\UserFirstNameStrategy;
use PHPUnit\Framework\TestCase;

class UserFirstNameStrategyTest extends TestCase
{
    /**
     * @dataProvider provideUserFirstNameStrategy
     */
    public function testUserFirstNameStrategy(string $text, QuoteDto $data, string $textExpected): void
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

        return [
            [$templateFake, new QuoteDto(user: $expectedUserAppContext), $templateFake],
            [$templateValid, new QuoteDto(user: $expectedUserAppContext), 'before '.$expectedUserAppContext->firstname.' after'],
            [$templateValid, new QuoteDto(user: $expectedUserData), 'before '.$expectedUserData->firstname.' after'],
        ];
    }
}
