<?php

class SetsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::app()->theme = null;
        $this->layout='//layouts/column2';

		$model=new Sets;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sets']))
		{
			$model->attributes=$_POST['Sets'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sets']))
		{
			$model->attributes=$_POST['Sets'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        Yii::app()->theme = null;
        $this->layout='//layouts/column2';

		$model=new Sets('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sets']))
			$model->attributes=$_GET['Sets'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Sets::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView()
    {
        $set_id = Yii::app()->request->getParam("set_id");
        $set    = Sets::model()->findByPk($set_id);
        if (!$set)
            throw new CHttpException(404, "Set is not exists");

        $model             = new Items();
        $model->creator_id = 1;
        $model->type_id    = 1;
        $model->set_id     = $set_id;
        $model->created_date = new CDbExpression('NOW()');

        $items = $set->items;
        $this->render('view',array(
            "model"=>$model,
            "set"=>$set,
            "items"=>$items
        ));
    }

    public function actionImport()
    {
        $set_id = Yii::app()->request->getParam("set_id");
        $set    = Sets::model()->findByPk($set_id);
        if (!$set)
            throw new CHttpException(404, "Set is not exists");

        $model             = new Items();
        $model->creator_id = 1;
        $model->type_id    = 1;
        $model->set_id     = $set_id;
        $model->created_date = new CDbExpression('NOW()');

        $items = $set->items;
        $this->render('import',array(
            "model"=>$model,
            "set"=>$set,
            "items"=>$items
        ));
    }

    public function actionImporttext(){
        // get request param
        $blocktext = Yii::app()->request->getParam("blocktext");
        $blocktext = "iPhone 5 Quick Tip: How to add letterboxing back to your iOS 6 app

So you've removed letterboxing from your iPhone 5 app by adding a Default-568h@2x.png launch image. And there was much rejoicing.

Except now all of your layouts are messed up, and you're supposed to push an app update through to the store tomorrow. So you delete the Default-568h@2x.png launch image and...nothing. Your app still seems to be running in full-screen mode. What's the deal?

It seems to be a bug, but there is a workaround. Here are the steps that I went through to re-enable letterboxing in XCode:
Remove the Default-568h@2x.png launch image
Run a Clean Build Folder
Uninstall the app from your device/simulator
Build and run the app
It's not immediately clear to me why you have to jump through so many hoops -- it might be that XCode is caching an intermediate version of the image resource in the build folder, and the device/simulator is simultaneously caching a version of this image in memory or on disk.

I'll update if I get more information.
";
        $blocktext = strip_tags($blocktext);
        $blocktext = str_replace(PHP_EOL, " ", $blocktext);
        $words = explode(" ", $blocktext);
        $real_words = array();
        foreach ($words as $word){
            $real_words[] = $this->getWord($word);
        }
        $real_words = array_unique($real_words);
        $means = array();
        $json  = "[";
        foreach ($real_words as $word){
            $word = strtolower($word);
            if ($word != ""){
                $json .= "{\"$word\":";
                $means[$word] = $this->getMeaning($word);
                $json .= "\"$means[$word]\"},";
            }
        }
        $json = rtrim($json, ",");
        $json .= "]";
        echo $json;
    }

    private function getMeaning($word){
        if ($word == "") return "";

        $item = Items::model()->findByAttributes(array("word"=>$word));
        if ($item)
            return $item->meaning;
        return "";

    }

    private function getWord($word){
        $i = strlen($word);
        while (($i > 0) and (!ctype_alpha($word[--$i])))
            $word[$i] = "\0";
        $word = chop($word);
        return $word;
    }

    /**
     * Learn new word
     * @throws CHttpException when set_id is not valid
     */
    public function actionPlay()
    {
        $set_id = Yii::app()->request->getParam("set_id");
        $set    = Sets::model()->findByPk($set_id);
        if (!$set)
            throw new CHttpException(404, "Set is not exists");

        $items = $set->items;
        $this->render('play',array(
            "set"=>$set,
            "items"=>$items
        ));
    }

    /**
     * Get list sets
     */
    public function  actionList() {
        $sets = Sets::model()->findAll();
        Yii::app()->end(CJSON::encode($sets));
    }
}
