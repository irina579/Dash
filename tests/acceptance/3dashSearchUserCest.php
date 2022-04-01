<?php

use Codeception\Util\Locator;
use Helper\Acceptance;
class dashSearchUserCest extends BaseActions
{
    protected string $userNameNewUser = 'KateTester5';
    protected string $emailNewUser = 'dashUser5@yopmail.com';
    protected string $firstNameNewUser = 'FirstNameTester';
    protected string $lastNameNewUser = 'LastNameTester';
    protected int $globalID = 115;

    protected int $newGlobalID = 124;
    /** @var Acceptance|null Acceptance helper */
    protected ?Acceptance $helper = null;


   /* public function _before(AcceptanceTester $I)
    {

    }*/

    // tests

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function loginToDash(AcceptanceTester $I)
    {
        $this->login($I);
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function searchForCreatedUser(AcceptanceTester $I){

        $this->openUsersPage($I);
        if ($I->dontSeePageHasElement("//li[@class='VTab__btn VTab__btn_search VTab__btn_active VTab__btn_next']")) {
            $I->click("//li[@class='VTab__btn VTab__btn_search VTab__btn_next']");
        }

        $I->fillField("//input[@class='search__input']", $this->userNameNewUser);
        $I->wait(3);
        $I->click("//button[@class='btn VButton']/child::span[contains(text(), 'Apply')]");
        $I->wait(3);
        $I->seeElement("//div[contains(text(), '"."$this->userNameNewUser"."')]");
        $I->seeElement("//div[contains(text(), '"."$this->emailNewUser"."')]");
     }


}
