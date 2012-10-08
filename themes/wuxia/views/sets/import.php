<?php
/**
 * @var $this ItemsController
 * @var $model Items
 * @var $set   Sets
 * @var $form CActiveForm
 */

    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("items/import.js"));
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("libs/underscore-min.js"));
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("libs/backbone-min.js"));
?>

<script>
    translateUrl = "<?php echo $this->createUrl("/")."/bing/translator.php" ?>";
    addUrl       = "<?php echo $this->createUrl("/items/add")?>";
</script>

<?php $this->renderPartial("/sets/_short",array("set"=>$set))?>

<div class="row" id="add-new-item">
    <div class="span12">
        <div class="content">
            <!-- Page header -->
            <div class="page-header">
                <h1><span class="icon-tasks"></span> Import <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">With Auto Translate</a></h1>
                <ul class="page-header-actions">
                    <li class="demoTabs active"> <a class="btn btn-wuxia" href="#blocktext">Block Text </a></li>
                    <li class="demoTabs">        <a class="btn btn-wuxia" href="#subtitle">Subtitle File  </a></li>
                    <li class="demoTabs">        <a class="btn btn-wuxia" href="#rikaichan">Rikaichan File</a></li>
                </ul>
            </div>
            <!-- /Page header -->
            <div class="tab-content page-container">



            <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Auto Translate Options</h3>
                </div>
                <div class="modal-body">
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
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">OK</button>
                </div>
            </div>
            <!-- Tab #bloc text-->
            <?php $this->renderPartial("_blocktext" ,array("model"=>$model, "set"=>$set))?>
            <!-- /Tab #single item -->


            <!-- Tab #subtitle item -->
            <?php $this->renderPartial("_multi" ,array("model"=>$model, "set"=>$set))?>
            <!-- /Tab #multi item -->
            </div>
        </div>
    </div>
</div>