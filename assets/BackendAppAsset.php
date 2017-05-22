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
        'js/codemirror/lib/codemirror.css',
    ];
    public $js = [
//        'js/jquery-resizable.js',
        'js/dashboard.js',
        'js/routing.js',
        'js/moment-with-locales.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/tinymce/tinymce.min.js',
        'js/bootstrap-notify.min.js',
        'js/codemirror/lib/codemirror.js',
        'js/codemirror/addon/selection/selection-pointer.js',
        'js/codemirror/mode/xml/xml.js',
        'js/codemirror/mode/javascript/javascript.js',
        'js/codemirror/mode/vbscript/vbscript.js',
        'js/codemirror/mode/htmlmixed/htmlmixed.js',
        'js/codemirror/mode/clike/clike.js',
        'js/codemirror/mode/php/php.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
