<?php

namespace models;

/**
 * Configuration
 * Configuration based in ini-files, readable via xpath style
 *
 * @author Mick van der Most van Spijk <mick@vandermostvanspijk.nl>
 * @version 2.0.1
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */
class config {
    private static $_settings = array();
    private static $_instance = NULL;
    private static $_dir;

    private function __construct($config_dir) {
        // chk configdir and read files
        $d =@ dir($config_dir);

        if (FALSE === $d) {
            throw new Exception("Config dir not found, unable to read configuration");
        }

        self::$_dir = $config_dir;

        // list confs
        $confs = array();
        while (false !== ($entry = $d->read())) {
            if (".." == $entry // current
                || "." == $entry // parent
                || substr($entry,0,1) == '.' // hidden
                || is_dir($entry)
            ) {
                continue;
            }

            $confs[] = $entry;
        }
        $d->close();

        foreach ($confs as $file) {
            self::$_settings[basename($file, '.ini')] = parse_ini_file($config_dir.'/'.$file, TRUE);
        }
    }

    public static function singleton($config_dir) {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($config_dir);
        }

        return self::$_instance;
    }

    /**
     * Get a setting by section and setting name or by specifing a path
     *
     * @param String section
     * @param String setting
     * or
     * @param Path ea section/setting
     * @return mixed value or empty string when not found
     */
    public static function getSetting() {
        if (NULL === self::$_instance) {
            throw new Exception ('Config not instanciated');
        }

        $args = func_get_args();
        $section = '';
        $setting = '';

        if (0 == count($args)) {
            throw new Exception('Please specify path or section and setting');
        }

        if (1 == count($args)) {
            $args[0] = trim($args[0], '/');
            $parts = explode("/", $args[0]);

            if (1 == count($parts)) {
                $ini = $parts[0];
            } elseif (2 == count($parts)) {
                $ini = $parts[0];
                $setting = $parts[1];
            } elseif (3 == count($parts)) {
                $ini = $parts[0];
                $section = $parts[1];
                $setting = $parts[2];
            } else {
                throw new Exception('Path is not correct, specify ini, section and setting or ini and setting');
            }
        } elseif (3 == count($args)) {
            $ini = $args[0];
            $section = $args[1];
            $setting = $args[2];
        }

        if (isset(self::$_settings[$ini])) {
            if ('' == $setting){
                return self::$_settings[$ini];
            } elseif ('' != $section) {
                if (isset(self::$_settings[$ini][$section])) {
                    if (isset(self::$_settings[$ini][$section][$setting])) {
                        return self::$_settings[$ini][$section][$setting];
                    }
                }
            } else {
                if (isset(self::$_settings[$ini][$setting])) {
                    return self::$_settings[$ini][$setting];
                }
            }
        }

        throw new Exception(sprintf('Setting %s not found', $setting));
    }

    public static function getIniFile($name) {
        if (NULL === self::$_instance) {
            throw new Exception ('Config not instanciated');
        }

        return parse_ini_file(self::$_dir.'/'.$name.".ini", TRUE);
    }
}
?>