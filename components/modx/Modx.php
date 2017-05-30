<?php

namespace yiix\components\modx;

use yii\base\Component;
use yiix\components\modx\base\Adapter;

class Modx extends Component
{
    const EVO = "evo";
    const REVO = "revo";

    public $version = "evo";
    private $_apiProvider = null;
    private  $_adapter = null;

    /**
     * @return Adapter
     */
    public function getAdapter()
    {
        if (!$this->_adapter) {
            if (\Yii::$app->modx->version == Modx::EVO) {
                $this->_adapter = new AdapterEvo();
            }
        }
        return $this->_adapter;
    }

    public function getApiProvider()
    {
        if ($this->_apiProvider == null) {
            if ($this->version = self::EVO) {
                $this->_apiProvider = ApiProviderEvo::instance();
            }
        }
        return $this->_apiProvider;
    }
}