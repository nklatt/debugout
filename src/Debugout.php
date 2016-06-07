<?php
namespace NKlatt\DebugOut;

class DebugOut
{
    protected static $indentationLevel  = 0;
    protected static $indentationString = '    ';
    protected static $scopeEnterString  = '--> ';
    protected static $scopeExitString   = '<-- ';

    protected $scopeName;
    protected $outputEnabled = false;

    public function __construct($scopeName, $flag)
    {
        $this->scopeName = $scopeName;
        if ($flag && $this->outputEnabled = DynamicDebug::isEnabled($flag)) {
            error_log($this->getIndent().self::$scopeEnterString.$scopeName);
            ++self::$indentationLevel;
        }
    }

    public function __destruct()
    {
        if ($this->outputEnabled) {
            --self::$indentationLevel;
            error_log($this->getIndent().self::$scopeExitString.$this->scopeName);
        }
    }

    public function putLine($message)
    {
        if ($this->outputEnabled) {
            error_log($this->getIndent().$message);
        }
    }

    protected function getIndent()
    {
        return str_repeat(self::$indentationString, self::$indentationLevel);
    }
}
