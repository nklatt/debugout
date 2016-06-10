<?php
use NKlatt\DebugOut\DebugOut;
use NKlatt\DebugOut\DynamicDebug;

class DebugOutTest extends PHPUnit_Framework_TestCase
{
    public function testDisabledOutput()
    {
        $testLogFile = dirname(__FILE__).'/test.log';
        if (file_exists($testLogFile)) {
            unlink($testLogFile);
        }
        $this->assertFalse(file_exists($testLogFile), "Unable to unlink '$testLogFile' prior to test.");

        $iniSetTestLogFile = ini_set('error_log', $testLogFile);
        $this->assertTrue($iniSetTestLogFile !== false, "Unable to ini_set('error_log', $testLogFile)");

        DynamicDebug::setEnabledFlags(array());
        $this->scopeA();
        $this->assertFalse(file_exists($testLogFile), 'Output erroneously generated.');

        if (file_exists($testLogFile)) {
            unlink($testLogFile);
        }
        $this->assertFalse(file_exists($testLogFile), "Unable to unlink $testLogFile after test.");
    }

    public function testEnabledOutput()
    {
        $testLogFile = dirname(__FILE__).'/test.log';
        if (file_exists($testLogFile)) {
            unlink($testLogFile);
        }
        $this->assertFalse(file_exists($testLogFile), "Unable to unlink $testLogFile prior to test.");

        $iniSetTestLogFile = ini_set('error_log', $testLogFile);
        $this->assertTrue($iniSetTestLogFile !== false, "Unable to ini_set('error_log', $testLogFile)");

        DynamicDebug::setEnabledFlags(array('SCOPE_A'));
        $this->scopeA();
        $this->assertTrue(file_exists($testLogFile), 'Output failed to be generated.');

        if (file_exists($testLogFile)) {
            unlink($testLogFile);
        }
        $this->assertFalse(file_exists($testLogFile), "Unable to unlink $testLogFile after test.");
    }

    protected function scopeA() {
        $debugOut = new DebugOut(__METHOD__, 'SCOPE_A');
    }

    public function testGenerateSampleOutput()
    {
        $testLogFile = dirname(__FILE__).'/sample.log';
        if (file_exists($testLogFile)) {
            unlink($testLogFile);
        }
        $this->assertFalse(file_exists($testLogFile), "Unable to unlink pre-existing $testLogFile.");

        $iniSetTestLogFile = ini_set('error_log', $testLogFile);
        $this->assertTrue($iniSetTestLogFile !== false, "Unable to ini_set('error_log', $testLogFile)");

        $this->fakeTrace();
        $this->assertTrue(file_exists($testLogFile), 'Output failed to be generated.');
    }

    protected function fakeTrace()
    {
        DynamicDebug::setEnabledFlags(array('ALL_THE_THINGS'));

        $this->outputPage();
    }

    protected function outputPage()
    {
        $debugOut = new DebugOut(__FUNCTION__, 'ALL_THE_THINGS');

        $this->outputHeader();
        $this->outputBody();
        $this->outputFooter();
    }

    protected function outputHeader()
    {
        $debugOut = new DebugOut(__FUNCTION__, 'ALL_THE_THINGS');

        $this->outputNav('header');
    }

    protected function outputBody()
    {
        $debugOut = new DebugOut(__FUNCTION__, 'ALL_THE_THINGS');

        $this->outputSidebar();
    }

    protected function outputSidebar()
    {
        $debugOut = new DebugOut(__FUNCTION__, 'ALL_THE_THINGS');

        $this->outputNav('sidebar');
    }

    protected function outputFooter()
    {
        $debugOut = new DebugOut(__FUNCTION__, 'ALL_THE_THINGS');
    }

    protected function outputNav($type)
    {
        $debugOut = new DebugOut(__FUNCTION__."($type)", 'ALL_THE_THINGS');

        $fakeSitemap = array( // title, show in header nav, show in sidebar nav
            array('title' => 'Home'       , 'header' => true  , 'sidebar' => false),
            array('title' => 'About'      , 'header' => true  , 'sidebar' => true),
            array('title' => 'History'    , 'header' => false , 'sidebar' => true),
            array('title' => 'Executives' , 'header' => false , 'sidebar' => true),
            array('title' => 'Careers'    , 'header' => false , 'sidebar' => true),
            array('title' => 'Contact'    , 'header' => true  , 'sidebar' => false),
            array('title' => 'Help'       , 'header' => true  , 'sidebar' => true)
        );
        foreach ($fakeSitemap as $fakePage) {
            if (true === $fakePage[$type]) {
                $debugOut->putLine("Adding to nav: {$fakePage['title']}");
            } else {
                $debugOut->putLine("Excluding from nav: {$fakePage['title']}");
            }
        }
    }
}
