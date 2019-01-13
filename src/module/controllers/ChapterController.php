<?php

namespace yii2module\guide\module\controllers;

use Yii;
use yii\web\Controller;

class ChapterController extends Controller {

	public function actionView($id = null) {
		$entity = \App::$domain->guide->chapter->oneByIdWithArticles($id);
		if($id) {
			$this->module->navigation->chapter($entity);
		}
		return $this->render('list', compact('entity'));
	}

}
