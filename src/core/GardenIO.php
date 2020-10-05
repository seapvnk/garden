<?php

define ('G_ERROR', 1);
define ('G_WARNING', 2);
define ('G_SUCCESS', 3);
define ('G_INFO', 4);

class GardenIO
{
    const G_PROMPT = ' ❀ Garden ';
    const EOL = PHP_EOL;
    const _TAB = '    '; 

    public static function print($str, $status = null)
    {
        $prompt = self::color(self::G_PROMPT, 'white' ,'bgreen');
        $str = " " . $str;
        if ($status) {
            $str = self::createEspecialMessage($str, $status);
        }

        echo "{$prompt}$str" . self::EOL; 
    }

    public static function inputCount()
    {
        return count(self::args());
    }

    public static function has($attr)
    {
        return isset($_GET[$attr]);
    }

    public static function getArgsThatStartsWith($str)
    {
        $args = [];
        if ($str === '.') {
            $str = '_';
        }

        foreach (array_keys(GardenIO::args()) as $arg) {
            $pos = strpos($arg, $str);
            if (is_bool($pos)) continue;

            if (strpos($arg, $str) == 0) {
                array_push($args, substr($arg, strlen($str)));
            }
        }

        return $args;
    }

    public static function argNextTo($str)
    {
        $returnNext = false;
        foreach (array_keys(GardenIO::args()) as $arg) {
            if ($returnNext) return $arg;
            if ($arg === $str) $returnNext = true;
        }
        return false;
    }

    public static function args($which = null)
    {
        if (!$which) {
            return $_GET;  
        } elseif (is_array($which)) {
            $inputs = [];
            foreach ($which as $input) {
                $input[$input] = $_GET[$input];
            }
            return $inputs;
        } else {
            return $_GET[$which];
        }
    } 

    public static function writeFile($path, $str)
    {
        $file = fopen($path, "w");
        fwrite($file, $str);
        fclose($file);
    }

    public static function delete($path)
    {
        unlink($path);
    }

    private static function createEspecialMessage($str, $type)
    {
        if ($type == G_ERROR) {
            $output = self::color(' Ops! ', 'white', 'red') . " " . self::color($str, 'red');
        } elseif ($type == G_WARNING) {
            $output = self::color(' Jeez ', 'black', 'yellow') . " " . self::color($str, 'yellow');
        } elseif ($type == G_SUCCESS) {
            $output = self::color(' Yay! ', 'bwhite', 'green') . " " . self::color($str, 'green');
        } else {
            $output = self::color(' Info ', 'bwhite', 'blue') . " " . self::color($str, 'cyan');
        }

        return $output;
    }

    private static function color($text, $color, $background = null)
    {
        // Colors
        $black = "[30m";
        $red = "[31m";
        $green = "[32m";
        $yellow = "[33m";
        $blue = "[34m";
        $magenta = "[35m";
        $cyan = "[36m";
        $white = "[37m";

        // Bright Colors
        $bblack = "[30;1m";
        $bred = "[31;1m";
        $bgreen =  "[32;1m";
        $byellow = "[33;1m";
        $bblue = "[34;1m";
        $bmagenta = "[35;1m";
        $bcyan = "[36;1m";
        $bwhite = "[37;1m";

        // Background Colors
        $Bblack = "[40m";
        $Bred = "[41m";
        $Bgreen = "[42m";
        $Byellow = "[43m";
        $Bblue = "[44m";
        $Bmagenta = "[45m";
        $Bcyan = "[46m";
        $Bwhite = "[47m";

        // Bright Background Colors
        $Bbblack = "[40;1m";
        $Bbred = "[41;1m";
        $Bbgreen = "[42;1m";
        $Bbyellow = "[43;1m";
        $Bbblue = "[44;1m";
        $Bbmagenta = "[45;1m";
        $Bbcyan = "[46;1m";
        $Bbwhite = "[47;1m";

        // Formating ouput
        $textc = ${strtolower($color)};
        $textColor = chr(27) . "{$textc}";
        if ($background) {
            $lowerbgc = strtolower($background);
            $bgc = ${"B{$lowerbgc}"};
            $backgroundColor = chr(27) . "{$bgc}";
        } else {
            $backgroundColor = '';
        }
        

        return  $textColor . $backgroundColor . "$text" . chr(27) . "[0m";
        
    }
}