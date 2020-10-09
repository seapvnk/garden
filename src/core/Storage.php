<?php

class Storage
{

    public static function getFile($file, $dir = '')
    {
        if ($dir !== '') {
            $dir .= '/';
        }
        $dir = self::getFolder() . $dir;
        return $dir . $file;
    }

    public static function getFolderContents($dir = '', $filters=[])
    {
        if ($dir !== '') {
            $dir .= '/';
        }
        $dir = self::getFolder() . $dir;
        
        @$raw = scandir($dir);
        if (!$raw) return [];

        $contents = [];
        $filterDir = in_array('dir', $filters);
        foreach ($raw as $content) {
            if ($content === '.' || $content === '..') continue;
            if (in_array(pathinfo($content, PATHINFO_EXTENSION), $filters)) continue;
            if ($filterDir && is_dir($dir . $content)) continue;
            $contents[] = $content;
        }

        return $contents;
    }

    public static function save($field, $dir = '')
    {
        if (!is_dir(self::getFolder())) {
            mkdir(self::getFolder());
        }

        if ($dir !== '') {
            $dir .= '/';
        }
        $dir = self::getFolder() . $dir;
        if (!is_dir($dir)) mkdir($dir);

        if (!count($_FILES) > 0 && isset($_FILES[$field])) {
            return false;
        }

        $uploadPath = self::generateUploadPath($dir, $_FILES[$field]['name']);
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $uploadPath)) {
            return $uploadPath;
        } else {
            return false;
        }
    }

    private static function generateUploadPath($dir, $file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $uploadPath = $dir . md5($file . time()) . '.' . $ext;
        return $uploadPath;
    }

    public static function getFolder()
    {
        return SRC_PATH . '/storage/';
    }
}
