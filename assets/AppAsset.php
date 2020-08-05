<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
        '//use.fontawesome.com/releases/v5.7.1/css/all.css',
    ];
    public $js = [
        "/js/jquery-3.4.1.min.js",
        "https://cdn.jsdelivr.net/npm/vue/dist/vue.js",
        "//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js",
        "//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js",
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
