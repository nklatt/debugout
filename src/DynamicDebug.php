<?php
namespace NKlatt\DebugOut;

class DynamicDebug
{
    protected static $configFile              = null;
    protected static $configFileNeedsChecking = true;
    protected static $enabledFlags            = array();

    public static function isEnabled($flag)
    {
        if (true === static::$configFileNeedsChecking) {
            static::checkConfig();
        }
        return in_array($flag, static::$enabledFlags);
    }

    public static function setEnabledFlags($enabledFlags)
    {
        if (is_array($enabledFlags)) {
            static::$enabledFlags = $enabledFlags;
        }
        static::$configFileNeedsChecking = false;
    }

    protected static function checkConfig()
    {
        if (static::$configFileNeedsChecking) {
            if (null === static::$configFile) {
                static::$configFile = dirname(dirname(__FILE__)).'/config.php';
            }
            if (file_exists(static::$configFile)) {
                include static::$configFile;
            }
            static::$configFileNeedsChecking = false; // successful or no, don't try again
        }
    }
}
