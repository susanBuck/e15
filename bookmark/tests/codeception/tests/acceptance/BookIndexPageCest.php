<?php

class BookIndexPageCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function showsNewBooks(AcceptanceTester $I)
    {
        $I->amOnPage('/test/login-as/1');
        $I->amOnPage('/books');

        # Assert there are 3 results
        $resultCount = count($I->grabMultiple('[test=new-book-link]'));
        $I->assertEquals(3, $resultCount);
    }
}
