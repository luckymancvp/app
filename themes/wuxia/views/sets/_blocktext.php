<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 1:17 PM
 * To change this template use File | Settings | File Templates.
 *
 *
 *
 * @var $this ItemsController
 * @var $model Items
 * @var $set   Sets
 * @var $form CActiveForm
 */


?>

<style>
    #response *{
        display: inline-block;
    }
</style>

<script>
    var importtextUrl = "<?php echo $this->createUrl("/sets/importtext")?>";
</script>

<script id="wordTemplate" type="text/template">
    <div class="word"> word </div> - <a href="#"> pass </a>
    <div id="popover" style="display:none"> never </div>
</script>

<div id="blocktext" class="tab-pane active">

    <!-- Grid row -->
    <div class="row">

        <article class="span12">
            <h2>Block text</h2>
        </article>

        <!-- Example vertical forms -->
        <!-- Page grid cell (4 blocks) -->
        <article class="span4">
            <textarea class="span4" style="margin-left: 0px;height: 300px;" name="blocktext" id="blocktext-input"></textarea>
            <input type="button" value="Save Item" name="yt1" id="import-item" class="btn btn-wuxia btn-large btn-primary">
        </article>
        <!-- /Page grid cell (4 blocks) -->

        <!-- Page grid cell (8 blocks) -->
        <article class="span8" id="response">
        </article>
        <!-- /Page grid cell (8 blocks) -->

    </div>

</div>
