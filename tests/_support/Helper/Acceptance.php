<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

    /**
     * @throws \Codeception\Exception\ModuleException
     */
    function dontSeePageHasElement($element)
    {
            $this->getModule('WebDriver')->_findElements($element);
    }

}
