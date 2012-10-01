<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 10/1/12
 * Time: 8:44 AM
 * To change this template use File | Settings | File Templates.
 *
 * * @var $set   Sets
 */

?>

<div class="content">

    <!-- Page header -->
    <div class="page-header">
        <h1>
            <span class="icon-star"></span> <?php echo $set->category->name." - ".$set->name?>
        </h1>
        <h4><span class="icon-edit" style="float:right"></span></h4>
    </div>
    <!-- /Page header -->

    <!-- Page container -->
    <div class="page-container">

        <!-- Grid row -->
        <div class="row">
            <div class="span3">
                <?php echo Html::timthumb($set->avatar)?>
            </div>

            <!-- Page grid cell (12 blocks - full) -->
            <article class="span6">
                <table class="table table-heavy">
                    <tbody>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("name")?></td>
                        <td><?php
                            if ($set->link) echo Html::link($set->name, $set->link);
                            else
                                echo $set->name;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("category_id")?></td>
                        <td><?php echo $set->category->name?></td>
                    </tr>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("description")?></td>
                        <td><?php echo $set->description?></td>
                    </tr>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("creator_id")?></td>
                        <td><?php echo $set->creator->username?></td>
                    </tr>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("created_date")?></td>
                        <td><?php echo $set->created_date?></td>
                    </tr>
                    <tr>
                        <td><?php echo $set->getAttributeLabel("last_try")?></td>
                        <td><?php echo $set->last_try?></td>
                    </tr>
                    </tbody>
                </table>
            </article>
            <!-- /Page grid cell (12 blocks - full) -->

        </div>
        <!-- /Grid row -->

    </div>
    <!-- /Page container -->
</div>