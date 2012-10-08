<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 10/1/12
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 *
 * @var $this SetsController
 * @var $model Items
 * @var $set   Sets
 */

    //  Js file
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("libs/underscore-min.js"));
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("libs/backbone-min.js"));
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("sets/play.js"));
?>

<script>
    var itemsJSON    = <?php echo CJSON::encode($set->items)?>;
    var updateUrl    = "<?php echo $this->createUrl("items/update")?>";
</script>

<script id="itemQuiz" type="text/template">
    <div class="row">
        <div class="hero-unit blow span4 offset3">
            <h1><%=word%> !</h1>
            <p>Do you know this word ?</p>
            <button class="btn btn-inverse no">No</button>
            <button class="btn btn-success yes">Yes</button>
        </div>
    </div>
</script>

<script id="quizEnd" type="text/template">
    <div class="row">
        <div class="hero-unit blow span4 offset3">
            <div class="nav-secondary">
                <nav>
                    <ul>
                        <li><a href="#" class="wuxify-me continue"><span class="icon-heart"></span>Continue</a><span class="badge badge-inverse"><%=loop%></span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</script>

<script id="quizAnswer" type="text/template">
    <div class="row">
        <div class="hero-unit blow span4 offset3">
            <h1><%=meaning%> !</h1>
            <p>is the meaning of <strong style="font-size: 25px"><%=word%></strong></p>
            <button class="btn btn-success ok">OK</button>
        </div>
    </div>
</script>

<div class="content" id="quiz-setup">

    <!-- Page header -->
    <div class="page-header">
        <h1>Welcome, Let's play and learn!</h1>
        <ul class="page-header-actions">
            <li><a class="btn btn-wuxia btn-success pull-right" href="#" data-original-title="Start Quiz" id="start-quiz"><span class="icon-bookmark"></span> Play Now</a></li>
        </ul>
    </div>
    <!-- /Page header -->

    <!-- Page container -->
    <div class="page-container">

        <!-- Grid row -->
        <div class="row">

            <!-- Page grid cell (4 blocks) -->
            <article class="span4">
                <p class="lead">Select play mode</p>
            </article>
            <!-- /Page grid cell (4 blocks) -->

            <!-- Page grid cell (8 blocks) -->
            <article class="span8">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="control-group">
                            <label for="select" class="control-label">Defined Mode</label>
                            <div class="controls">
                                <select id="select">
                                    <option>All</option>
                                    <option>Medium</option>
                                    <option>Hard</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">List Order</label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" checked="checked" value="seq" name="optionRadio">
                                    Sequence
                                </label>
                                <label class="radio">
                                    <input type="radio" value="ran" name="optionRadio">
                                    Random
                                </label>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </article>
            <!-- /Page grid cell (8 blocks) -->

        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Page container -->

</div>

<div class="content" id="quiz-progress">

    <!-- Page header -->
    <div class="page-header">
        <h1>Play Progress</h1>
        <ul class="page-header-actions">
            <!--<li><a class="btn btn-wuxia btn-success pull-right" href="#" data-original-title="Start Quiz" id="start-quiz"><span class="icon-bookmark"></span> Play Now</a></li>-->
        </ul>
    </div>
    <!-- /Page header -->

    <!-- Page container -->
    <div class="page-container">

        <!-- Grid row -->
        <div class="row">
            <div class="span6">
                <div style="margin-bottom: 9px;" class="progress progress-success progress-striped">
                    <div style="width: 0%" class="bar" id="progress-bar">0%</div>
                </div>
            </div>
            <div class="span3">
                <div>
                    Loop: <div id="loop" style="display: inline-block;">0</div> | True : <div id="true" style="display: inline-block;">0</div> | Wrong : <div id="wrong" style="display: inline-block;">0</div> | Total : <div id="total" style="display: inline-block;">0</div>
                </div>
            </div>
        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Page container -->

</div>

<div id="quizZone"></div>