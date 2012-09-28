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

<div id="single" class="tab-pane active">

    <!-- Grid row -->
    <div class="row">

        <article class="span12">
            <h2>Single Item</h2>
        </article>

        <!-- Example vertical forms -->
        <!-- Page grid cell (4 blocks) -->
        <article class="span4">
            <p>You can add word by word in this panel. </p>
            <p>Tips : You should better use pre-defined meaning and use hotkey</p>
        </article>
        <!-- /Page grid cell (4 blocks) -->

        <!-- Page grid cell (8 blocks) -->
        <article class="span8">
            <?php
            $form = $this->beginWidget("CActiveForm", array(
                "htmlOptions"=>array(
                    "class"  => "form-horizontal",
                    "onsubmit" => new CJavaScriptExpression("return false"),
                ),
            ));
            echo $form->hiddenField($model, "set_id");
            ?>
            <fieldset>
                <div class="control-group">
                    <label for="select" class="control-label">Pre-defined source</label>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList("predefined", 1, array(
                            "0"=>"No pre-defined",
                            "1"=>"Bing Translate",
                            "2"=>"Tratu.vn",
                            "3"=>"System",
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="select" class="control-label">Select Language</label>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList("from", "en",
                            array(
                                "en"=>"en",
                                "ja"=>"ja",
                                "vi"=>"vi",
                            ),
                            array(
                                "style"=>"width : 50px",
                            )
                        );
                        echo " ";
                        echo CHtml::button("<->", array(
                            "class"=>"btn",
                            "onClick"=>new CJavaScriptExpression("swapLanguage()"),
                        ));
                        echo " ";
                        echo CHtml::dropDownList("to", "vi",
                            array(
                                "en"=>"en",
                                "ja"=>"ja",
                                "vi"=>"vi",
                            ),
                            array(
                                "style"=>"width : 50px",
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, "word", array("class"=>"control-label"))?>
                    <div class="controls">
                        <?php echo $form->textField($model, "word", array("class"=>"input-xlarge"));?>
                        <span id="predefining" style="float:right; display: none;" class="loading red" data-original-title="Loading, please wait…">Loading…</span>
                        <p class="help-block">Insert your word here</p>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, "meaning", array("class"=>"control-label"))?>
                    <div class="controls">
                        <?php echo $form->textArea($model, "meaning", array("class"=>"input-xlarge", "rows"=>5));?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    echo CHtml::ajaxButton(
                        'Save Item',
                        array('/items/add'),
                        array(
                            "data"=>new CJavaScriptExpression('jQuery(this).parents("form").serialize()'),
                            "type"=>"GET",
                            "beforeSend"=>new CJavaScriptExpression('function(e){
                                                    $("#loading-save").show();
                                                }'),
                            "success"=>new CJavaScriptExpression('function(e){
                                                    $("#loading-save").hide();

                                                    $("#Items_meaning").val("");
                                                    $("#Items_word").val("");
                                                    $("#Items_word").focus();
                                                }'),
                        ),
                        array(
                            "class"=>"btn btn-wuxia btn-large btn-primary",
                            "id"=>"save-item",
                        )
                    );
                    ?>
                    <span id="loading-save" style="float:right; display: none;" class="loading orange" data-original-title="Loading, please wait…">Loading…</span>
                </div>
            </fieldset>
            <?php $this->endWidget()?>
        </article>
        <!-- /Page grid cell (8 blocks) -->

    </div>
    <div class="row" id="list-items">

    </div>

</div>
