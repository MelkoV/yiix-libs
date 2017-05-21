<?php

namespace yiix\components\modx;

use yiix\components\modx\base\Adapter;

class AdapterEvo extends Adapter
{

    public function getResourceField($name)
    {
        return "[*".$name."*]";
    }

}