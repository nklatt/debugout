<?php
namespace NKlatt\DebugOut;

class DynamicDebug
{
    protected static $configFile        = null;
    protected static $configFileChecked = false;
    protected static $enabledFlags      = array();

    public static function isEnabled($flag)
    {
        if (false === self::$configFileChecked) {
            self::checkConfig();
        }
        return in_array($flag, self::$enabledFlags);
    }

    public static function setEnabledFlags($enabledFlags)
    {
        if (is_array($enabledFlags)) {
            self::$enabledFlags = $enabledFlags;
        }
    }

    protected static function checkConfig()
    {
        if ( ! self::$configFileChecked ) {
            if (null === self::$configFile) {
                self::$configFile = dirname(dirname(__FILE__)).'/config.php';
            }
            if (file_exists(self::$configFile)) {
                include self::$configFile;
            }
            self::$configFileChecked = true; // successful or not, don't try again
        }
    }
}
