<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 1:37 PM
 * To change this template use File | Settings | File Templates.
 *
 * @var $this ItemsController
 * @var $model Items
 * @var $set   Sets
 * @var $form CActiveForm
 */

?>

<script>
    var itemsJSON    = [{},{}];
    var delItemUrl   = "<?php echo $this->createUrl("/items/del")?>";
    var translateUrl = "<?php echo $this->createUrl("/")."/bing/translator.php" ?>";
    var saveUrl      = "<?php echo $this->createUrl("/items/save")?>";
</script>

<script id="itemRow" type="text/template">
    <td class="select-checkbox-td">
        <input type="checkbox" id="select-checkbox" name="select-checkbox" value="1" checked="checked">
        <div style="display:none" class="progress progress-success progress-striped active">
            <div style="width: 100%" class="bar"></div>
        </div>
    </td>
    <td><%=id%></td>
    <td><%=word%></td>
    <td><%=meaning%></td>
    <td><%=sound%></td>
    <td>
        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="button" class="btn btn-danger del">Del</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success edit">Edit</button>
            </div>
        </div>
    </td>
</script>

<script id="itemBlank" type="text/template">
    <td class="select-checkbox-td">
        <input type="checkbox" id="select-checkbox" name="select-checkbox" value="1" checked="checked">
        <div style="display:none" class="progress progress-success progress-striped active">
            <div style="width: 100%" class="bar"></div>
        </div>
    </td>
    <td><%if(typeof(id) != "undefined") {%><%=id%><%}%></td>
    <td><input type="text" value="<%=word%>" maxlength="45" id="Items_word" name="Items[word]" tabindex="1"></td>
    <td><input type="text" value="<%=meaning%>" maxlength="255" id="Items_meaning" name="Items[meaning]" tabindex="1"></td>
    <td><input type="text" value="<%=sound%>" maxlength="255" id="Items_sound" name="Items[sound]"></td>
    <td>
        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="button" class="btn btn-danger del">Del</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info trans">Trans</button>
                <button type="button" class="btn btn-success save">Save</button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-inverse cancel">Cancel</button>
            </div>
        </div>
    </td>
</script>

<div id="multi" class="tab-pane">

    <!-- Grid row -->
    <div class="row">

        <article class="span12">
            <div class="row">
                <div class="span6">
                    <h2>Multi Items</h2>
                </div>
            </div>

            <table class="datatable table table-striped table-bordered" id="table-items">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Word</th>
                    <th>Meaning</th>
                    <th>Sound</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="row">
                <div class="span4">
                    <div class="btn-toolbar">
                        <div class="btn-group btn-mini">
                            <a id="add-more" class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#">Add More <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                echo CHtml::tag("li",array(), CHtml::link("+5","#add-more",array(
                                    "onClick"=>new CJavaScriptExpression("masterView.addBlank(5)"),
                                )));
                                echo CHtml::tag("li",array(), CHtml::link("+10","#add-more",array(
                                    "onClick"=>new CJavaScriptExpression("masterView.addBlank(10)"),
                                )));
                                echo CHtml::tag("li",array(), CHtml::link("+15","#add-more",array(
                                    "onClick"=>new CJavaScriptExpression("masterView.addBlank(15)"),
                                )));
                                ?>
                                <li class="divider"></li>
                                <li><a href="#">Custom</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger control-a" id="del">Delete All</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info control-a" id="trans">Translate All</button>
                            <button type="button" class="btn btn-success control-a" id="save">Save All</button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!-- /Page grid cell (12 blocks - full) -->

    </div>
    <!-- /Grid row -->
</div>



<!-- jQuery DataTable -->
<?php
    Yii::app()->clientScript->registerScriptFile(Html::jsThemeUrl("sets/index.js"));
?>