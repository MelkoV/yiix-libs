<?php

namespace yiix\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class BackendAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashboard.css',
        'css/bootstrap-datetimepicker.min.css',
    ];
    public $js = [
//        'js/jquery-resizable.js',
        'js/dashboard.js',
        'js/routing.js',
        'js/moment-with-locales.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/tinymce/tinymce.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
