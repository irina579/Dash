<?php

use Codeception\Util\Locator;
use Helper\Acceptance;
class dashCreateUserCest extends BaseActions
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

    public function createUser(AcceptanceTester $I)
    {
        $I->wait(3);
        $I->amOnPage('/Home/Homepage');
        $this->openUsersPage($I);
        $I->seeElement('//span[contains(text(),"Create new user")]');
        $I->click('//span[contains(text(),"Create new user")]');
        $I->wait(3);
        $I->click('//span[contains(text(),"Username")]/following::input[1]');
        $I->fillField('//span[contains(text(),"Username")]/following::input[1]', $this->userNameNewUser);
        $I->click('//span[contains(text(),"Email Address")]/following::input[1]');
        $I->fillField('//span[contains(text(),"Email Address")]/following::input[1]', $this->emailNewUser);
        $I->click('//span[contains(text(),"First Name")]/following::input[1]');
        $I->fillField('//span[contains(text(),"First Name")]/following::input[1]', $this->firstNameNewUser);
        $I->click('//span[contains(text(),"Last Name")]/following::input[1]');
        $I->fillField('//span[contains(text(),"Last Name")]/following::input[1]', $this->lastNameNewUser);
        $I->click('//span[contains(text(),"Global")]/following::input[1]');
        $I->fillField('//span[contains(text(),"Global")]/following::input[1]', $this->globalID);
        $I->wait(3);

        if ($I->dontSeePageHasElement("//li[@class='VTab__btn VTab__btn_MPCFilm VTab__btn_active']")) {
            $I->click("//li[@class='VTab__btn VTab__btn_MPCFilm VTab__btn_next']");
        }

        $arrayDepartments = $I->grabMultiple("//label[contains(text(), 'Select all')]");
        $sumDepartments = count($arrayDepartments);

        for($x=1; $x<=$sumDepartments; $x++) {
            $I->click("(//label[contains(text(), 'Select all')])["."$x".']');
        }

        $arrayPermissions = $I->grabMultiple("//div[@class='ui-checkbox table-row-group__btns__checkbox ui-checkbox_default']");
        $sumPermission = count($arrayPermissions);
        for($d=1; $d<=$sumPermission; $d++){
            $I->click("(//div[@class='ui-checkbox table-row-group__btns__checkbox ui-checkbox_default'])[".$d."]");
        }


        $I->click("//span[contains(text(), 'Create')]");
        $I->wait(3);


        if ($I->tryToSeeElement("//div[contains(text(), 'Global ID cannot be linked to this user')]")){
            $I->click("//span[contains(text(), 'Ok')]");
            $I->clearField('//span[contains(text(),"Global")]/following::input[1]');
            $I->wait(3);
            $I->fillField('//span[contains(text(),"Global")]/following::input[1]', $this->newGlobalID);
            $I->click("//span[contains(text(), 'Create')]");
            $I->wait(3);
        }

        if ($I->tryToSeeElement("//div[contains(text(), 'This global ID does')]")) {
            $I->click("//span[contains(text(), 'Yes')]");
            $I->wait(5);
        }


        $I->seeElement("//div[contains(text(), 'User Info')]");
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     */

}
