<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'urlManager'=>array(
                'showScriptName'=>true,
            ),
            'db'=>array(
                'enableProfiling'=>true,
            ),
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    //テストのためブラウザでひょうじする
                    array(
                        'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    ),
                ),
            ),
            /* uncomment the following to provide test database connection
               'db'=>array(
                   'connectionString'=>'DSN for test database',
               ),
               */
        ),
    )
);
