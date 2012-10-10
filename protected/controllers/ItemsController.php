<?php

class ItemsController extends Controller
{
	public function actionIndex()
	{
        die("index");
	}

    public function actionTranslate(){
        $this->render("translate");
    }

    public function actionSave()
    {
        // Get model from request
        if (isset($_REQUEST["Items"])&&isset($_REQUEST["Items"]["id"]))
            $model = Items::model()->findByPk($_REQUEST["Items"]["id"]);
        else{
            $model   = new Items();
            $model->creator_id   = 1;
            $model->type_id      = 1;
            $model->created_date = new CDbExpression('NOW()');
        }

        if (isset($_REQUEST["Items"])){
            $model->attributes = $_REQUEST["Items"];

            if ($model->save()){
                Yii::app()->end(CJSON::encode(array(
                    "status"=>"0",
                    "id"    =>$model->id,
                )));
            }
            else{
                throw new CHttpException("123",array(
                    "status"=>1,
                    "explain"=>CVarDumper::dump($model->errors))
                );
            }
        }
    }

    public function actionDel()
    {
        $item_id = Yii::app()->request->getParam("item_id");
        $item    = Items::model()->findByPk($item_id);
        if (!$item)
            throw new CHttpException(404, "Item is not exists");

        if ($item->delete())
            Yii::app()->end("1");
        Yii::app()->end(CJSON::encode($item->errors));
    }

    public function actionUpdate()
    {
        // get request param
        $item_id = Yii::app()->request->getParam("item_id");
        $result  = Yii::app()->request->getParam("result");
        $item    = Items::model()->findByPk($item_id);
        if (!$item)
            throw new CHttpException(404, "Item is not exists");

        // update static
        $item->total++;
        $item->last_try = new CDbExpression("NOW()");

        switch ($result){
            case "know":
                $item->success++;
                break;
        }

        // save model
        if (!$item->save()){
            return var_dump($item->errors);
        }
    }
}