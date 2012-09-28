<?php
/**
 * Created by JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/24/12
 * Time: 9:13 AM
 * To change this template use File | Settings | File Templates.
 */

$items = new Items();
$this->widget("zii.widgets.grid.CGridView", array(
    "dataProvider" => $items->search(),
));