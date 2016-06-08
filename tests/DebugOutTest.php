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
}
