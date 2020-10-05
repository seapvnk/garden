<?php

class View
{
    private $content = [];
    
    public function __construct($properties = [])
    {
        $this->content += $properties;
    }

    public function output(int $response)
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
}