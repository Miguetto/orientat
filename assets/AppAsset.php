<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

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
        'css/style-copy.css',
        'css/open-iconic-bootstrap.min.css',
        'css/animate.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/magnific-popup.css',
        //'css/aos.css',
        'css/ionicons.min.css',
        'css/flaticon.css',
        'css/icomoon.css',
        'css/jquery.sBubble-0.1.1.css',
    ];
    public $js = [
        'js/pluginNoclase.js',
        '//cdn.jsdelivr.net/jquery.typeit/3.0.1/typeit.min.js',
        'js/code.js',
        'js/sw.js',
        'js/jquery.sBubble-0.1.1.js',
        '//cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
    ];
}
