<?php


class testBackCest
{
    public function canGetUserList(ApiTester $I)
    {
        $I->haveHttpHeader("Accept", "application/json");
        $I->sendGET('back/users');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"guid":"00000000000000000000000000000000"');
        $I->seeResponseContains('"guid":"00000000000000000000000000000001"');

        // Can get positions
        $I->sendGET('back/users', ['expand' => 'positions']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"longitude":5,"latitude":5,"time":"2019-05-05 12:00:05"');
        $I->seeResponseContains('"longitude":3,"latitude":3,"time":"2019-05-05 12:00:03"');
    }
}
