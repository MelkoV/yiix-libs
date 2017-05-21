<?php

namespace yiix\widgets;


use yii\bootstrap\ActiveField;

class BackendActiveField extends ActiveField
{

    public function begin()
    {
        $tooltip = $this->model->getAttributeDescription($this->attribute);
        if ($tooltip) {
            $this->options["data-toggle"] = "tooltip";
            $this->options["data-placement"] = "bottom";
            $this->options["data-html"] = "true";
            $this->options["title"] = $tooltip;
        }
        return parent::begin();
    }
}