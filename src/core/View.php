<?php

class View
{
    private $content = [];
    
    public function __construct($properties = [])
    {
        $this->content += $properties;
    }

    public static function template($name, $params = [])
    {
        // binding variables
        if (count($params) > 0) {
            foreach ($params as  $variable => $value) {
                if (strlen($variable) > 0) {
                    // Set g_vars
                    $GLOBALS["gv_" . $variable] = $value;
                }
            }
        }

        $filePath = Loader::template($name);
        $template = self::readTemplateFile($filePath);

        // replace view syntax by php syntax
        $template = str_replace("{{", "<?=", $template);
        $template = str_replace("{@", "<?php", $template);
        $template = str_replace("}}", "?>", $template);
        // view shortag
        $template = str_replace("{%", "<?php view('", $template);
        $template = str_replace("%}", "')?>", $template);
            

        $tmpFile = uniqid("garden_view_");
        $tmpFilePath = VIEW_PATH . "/" . $tmpFile . ".php";

        touch($tmpFilePath);
        $tmpFileHandle = fopen($tmpFilePath, "w");
        fwrite($tmpFileHandle, $template);
        fclose($tmpFileHandle);
        Loader::view($tmpFile);


        unlink($tmpFilePath);

        
    }

    public function outputJSON(int $response)
    {
        http_response_code($response);
        echo json_encode($this->content);
    }

    public function set($attr, $value)
    {
        $this->content[$attr] = $value;
    }

    public function pushModel(Model $model, $to = null)
    {
        if (!$to) $to = strtolower(get_class($model))."s";
        if (!isset($this->content[$to])) {
            $this->content[$to] = [];
            array_push($this->content[$to], $model->view());
        } else {
            array_push($this->content[$to], $model->view());
        }
    }

    public function setModelAs(Model $model, $attr)
    {
        $this->content[$att] = $model->view();
    }

    private static function readTemplateFile($filePath)
    {
        $file = fopen($filePath, "r");
        $template = '';
        while(! feof($file)) {
            $line = fgets($file);
            $template .= $line;
        }

        fclose($file);
        return $template;
    }
}
