<?php

use Codeception\Util\Locator;
use Helper\Acceptance;

/**
 * @method setUserName(string $string)

 */
class createUserWithFileCest extends BaseActions
{
    protected ?string $userNameNewUser = null;
    protected ?string $emailNewUser = null;
    protected ?string $firstNameNewUser = null;
    protected ?string $lastNameNewUser = null;
    protected ?int $globalID = null;
    protected ?int $newGlobalID = null;

    /** @var Acceptance|null Acceptance helper */
    protected ?Acceptance $helper = null;

    // tests


    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     */

    public function loginToDash(AcceptanceTester $I)
    {
        $this->login($I);
    }

    public function variablesFromFile(AcceptanceTester $I)
    {
        $assoc_array = [];
        if (($handle = fopen("E:\Automation\Dash\Test.csv", "r")) !== false) {                 // open for reading
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {         // extract header data
                $keys = $data;                                             // save as keys
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {      // loop remaining rows of data
                $assoc_array[] = array_combine($keys, $data);              // push associative subarrays
            }
            fclose($handle);                                               // close when done
        }
//        echo "<pre>";
//        var_export($assoc_array);                                      // print to screen
//        echo "</pre>";


        // echo "</pre>";
        //  exit;


        foreach ($assoc_array as $items) {
            //$items = $assoc_array[1];
            $this->userNameNewUser = $items['userName'];
            $this->emailNewUser = $items['emailNewUser'];
            $this->firstNameNewUser = $items['firstNameNewUser'];
            $this->lastNameNewUser = $items['lastNameNewUser'];
            $this->globalID = $items['globalID'];

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

            if ($I->tryToSeeElement("//li[@class='VTab__btn VTab__btn_MPCFilm VTab__btn_next']")) {
                $I->click("//li[@class='VTab__btn VTab__btn_MPCFilm VTab__btn_next']");
            }

            $arrayDepartments = $I->grabMultiple("//label[contains(text(), 'Select all')]");
            $sumDepartments = count($arrayDepartments);
            for ($x = 1; $x <= $sumDepartments; $x++) {
                $I->click("(//label[contains(text(), 'Select all')])[" . "$x" . "]");
            }


            $arrayPermissions = $I->grabMultiple("//div[@class='ui-checkbox table-row-group__btns__checkbox ui-checkbox_default']");
            $sumPermission = count($arrayPermissions);
            for ($d = 1; $d <= $sumPermission; $d++) {
                $I->click("(//div[@class='ui-checkbox table-row-group__btns__checkbox ui-checkbox_default'])[" . $d . "]");
            }


            $I->click("//span[contains(text(), 'Create')]");
            $I->wait(3);


            if ($I->tryToSeeElement("//div[contains(text(), 'Global ID cannot be linked to this user')]")) {
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

            $I->see('User Info');

            $userNameValue = $I->grabValueFrom('//span[contains(text(),"Username")]/following::input[1]');
            $I->assertEquals($userNameValue, $this->userNameNewUser);

            $I->seeInField('//span[contains(text(),"Email Address")]/following::input[1]', $this->emailNewUser);
            $I->seeInField('//span[contains(text(),"First Name")]/following::input[1]', $this->firstNameNewUser);
            $I->seeInField('//span[contains(text(),"Last Name")]/following::input[1]', $this->lastNameNewUser);
            $I->seeInField('//span[contains(text(),"Global")]/following::input[1]', (string)$this->globalID);

            for ($x = 1; $x <= $sumDepartments; $x++) {
                $I->seeCheckboxIsChecked("(//div[contains(@class,'ui-checkbox table-content__column__item__select-all ui-checkbox_default')]/input)[".$x."]");
            }

            for ($d = 1; $d <= $sumPermission; $d++) {
                $I->seeCheckboxIsChecked("(//div[contains(@class,'ui-checkbox table-row-group__btns__checkbox ui-checkbox_default')]/input)[".$d."]");
            }

        }

    }
}