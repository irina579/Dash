<?php

class BaseActions{
    protected string $dashLogin = 'global';
    protected string $dashPass = 'global';

    # protected $testLogin = null;
    #  protected $testLoginPass = null;

    /** @var Acceptance|null Acceptance helper */

    protected function login (AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(3);
        $I->fillField('#UserName', $this->dashLogin);
        $I->fillField('#Password', $this->dashPass);
        $I->click('//button[contains(text(),"Log in")]');
        $I->wait(5);
        $I->waitForElementVisible('//div[contains(text(), "Welcome back")]', 30);
        $I->wait(3);
        $I->click('//span[@class="header-banner__close-button"]');
    }

    protected function openUsersPage(AcceptanceTester $I){
        $I->click('//div[contains(text(),"Users")]');
        $I->wait(3);
    }
}