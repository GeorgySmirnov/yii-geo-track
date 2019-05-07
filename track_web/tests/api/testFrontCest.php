<?php


class testFrontCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function canLogInAndLogOut(ApiTester $I)
    {
        // login
        $I->haveHttpHeader("Accept", "application/json");
        $I->sendPOST('front/login', ['telephone' => '70000000000', 'pass' => 'password']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"success":true');
        $I->seeResponseContains('"guid":"00000000000000000000000000000000"');

        // logout
        $I->sendGET('front/logout');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        
        // can't acess logout if not logged in
        $I->sendGET('front/logout');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
    }

    public function checksUserCredentials(ApiTester $I)
    {
        $I->haveHttpHeader("Accept", "application/json");
        $I->sendPOST('front/login', ['telephone' => '70000000000', 'pass' => 'wrong_password']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"success":false');

        // can't acess logout if not logged in
        $I->sendGET('front/logout');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::FORBIDDEN);
    }

    public function canInsertNewPosition(ApiTester $I)
    {
        // login
        $I->haveHttpHeader("Accept", "application/json");
        $I->sendPOST('front/login', ['telephone' => '70000000000', 'pass' => 'password']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->sendPOST('front/insert-position', [
            'longitude' => 0,
            'latitude' => 0,
            'time' => date(\DateTime::ISO8601),
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"success":true');
    }
}
