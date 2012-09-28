<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/23/12
 * Time: 10:21 AM
 * To change this template use File | Settings | File Templates.
 *
 * @var $this CController
 */

?>

<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js ie7 ie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Dashboard | Wuxia Bootstrap Admin Template</title>
    <meta name="description" content="">
    <meta name="author" content="Walking Pixels | www.walkingpixels.com">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS styles -->
    <?php
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile(Html::cssThemeUrl("wuxia-red.css"));

        $cs->registerCoreScript("jquery");
        $cs->registerScriptFile(Html::jsThemeUrl("libs/modernizr.js"));
        $cs->registerScriptFile(Html::jsThemeUrl("libs/selectivizr.js"));
    ?>

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/icons/apple-touch-icon-57-precomposed.png">

    <script>
        $(document).ready(function(){

            // Navbar tooltips
            $('.navbar [title]').tooltip({
                placement: 'bottom'
            });

            // Content tooltips
            $('[role=main] [title]').tooltip({
                placement: 'top'
            });

            // Dropdowns
            $('.dropdown-toggle').dropdown();

        });
    </script>
</head>
<body>

<!-- Main navigation bar -->
<header class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".user">
                <span class="icon-user"></span>
            </button>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".navigation">
                <span class="icon-chevron-down"></span>
            </button>
            <a class="brand" href="http://envato.walkingpixels.com/themes/wuxia/">Walking Pixels Wuxia Bootstrap admin template</a>
            <nav class="nav-collapse navigation">
                <ul class="nav" role="navigation">
                    <li class="active"><a href="index.html" title="Homepage dashboard"><span class="icon-home"></span> Dashboard</a></li>
                    <li><a href="forms.html" title="Form elements"><span class="icon-tasks"></span> Forms</a></li>
                    <li><a href="tables.html" title="Static and dynamic tables"><span class="icon-table"></span> Tables</a></li>
                    <li><a href="typography.html" title="Typography showcase"><span class="icon-font"></span> Typography</a></li>
                    <li><a href="ui-buttons.html" title="Buttons in navbar!"><span class="icon-magic"></span> UI &amp; Buttons</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="#" title="Buttons in navbar!" class="btn-wuxia-navbar"><div class="btn btn-wuxia"><span class="icon-key"></span> Widgets</div></a></li>
                </ul>
            </nav>
            <nav class="nav-collapse user">
                <div class="user-info pull-right">
                    <img src="#" alt="User avatar">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <div><strong>John Pixel</strong>Administrator</div>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href=""><span class="icon-cogs"></span> Account settings</a></li>
                            <li><a href=""><span class="icon-bell"></span> Preferences</a></li>
                            <li><a href=""><span class="icon-envelope"></span> Email notifications</a></li>
                            <li class="divider"></li>
                            <li><a href=""><span class="icon-signout"></span> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- /Main navigation bar -->

<!-- Main content -->
<div class="container" role="main">

    <!-- Breadcrumbs -->
    <?php
    $controllerID = Yii::app()->controller->id;
    $actionID     = Yii::app()->controller->action->id;
    ?>
    <ul class="breadcrumb">
        <?php
            echo Html::tag(
                "li",
                array(),
                Html::link("<span class='icon-home'></span> Home</a>", Yii::app()->homeUrl)
            );
            echo Html::tag(
                "li",
                array(),
                Html::link("$controllerID",$this->createUrl("/$controllerID"))
            );
            echo Html::tag(
                "li",
                array("class"=>"active"),
                $actionID
            );
        ?>
    </ul>
    <!-- Breadcrumbs -->
    <?php echo $content?>
</div>
<!-- /Main content -->

<!-- Main footer -->
<footer class="container">
    <nav>
        <ul>
            <li>&copy; Copyright 2012. All rights reserved.</li>
            <li><a href="">Documentation</a></li>
            <li><a href="">Support</a></li>
            <li><a href="">API</a></li>
            <li><a href="">Blog</a></li>
        </ul>
    </nav>
    <p>Built with love on <a href="http://twitter.github.com/bootstrap/">Twitter Bootstrap</a> by <a href="http://www.walkingpixels.com">Walking Pixels</a>.</p>
</footer>
<!-- /Main footer -->

<!-- Scripts -->

<?php
    $cs->registerScriptFile(Html::jsThemeUrl("navbar.js"));
    $cs->registerScriptFile(Html::jsThemeUrl("plugins/waypoints.min.js"));
    $cs->registerScriptFile(Html::jsThemeUrl("bootstrap/bootstrap-tooltip.js"));
    $cs->registerScriptFile(Html::jsThemeUrl("bootstrap/bootstrap-dropdown.js"));
    $cs->registerScriptFile(Html::jsThemeUrl("bootstrap/bootstrap-collapse.js"));
?>

</body>
</html>
