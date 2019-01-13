<?php

namespace yii2module\guide\module\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii2lab\domain\exceptions\UnprocessableEntityHttpException;
use yii2lab\extension\web\helpers\Behavior;
use yii2lab\navigation\domain\widgets\Alert;
use yii2module\guide\domain\entities\ArticleEntity;
use yii2module\guide\domain\enums\GuidePermissionEnum;
use yii2module\guide\module\forms\ArticleForm;
use yii2module\guide\module\helpers\NavigationHelper;

class ArticleController extends Controller {

	public function behaviors() {
		return [
			'access' => Behavior::access(GuidePermissionEnum::MODIFY, ['update', 'delete']),
		];
	}

	public function actionIndex() {
		$entity = \App::$domain->guide->article->oneMain();
		return $this->render('view', compact('entity'));
	}

	public function actionView($id = null) {
		try {
			if($id) {
				$entity = \App::$domain->guide->article->oneByIdWithChapter($id);
				$this->module->navigation->articleAndChapter($entity);
			}
			return $this->render('view', compact('entity'));
		} catch(NotFoundHttpException $e) {
			$chapter = \App::$domain->guide->repositories->chapter->oneByArticleId($id);
			return $this->render('viewNotFound', compact('id'));
		}
	}

	public function actionCode($id) {
		$entity = \App::$domain->guide->article->oneByIdWithChapter($id);
		$this->module->navigation->articleAndChapter($entity);
		$this->module->navigation->articleCode($entity);
		return $this->render('code', compact('entity'));
	}

	public function actionUpdate($id) {
		$model = new ArticleForm();
		if(Yii::$app->request->isPost) {
			$body = Yii::$app->request->post('ArticleForm');
			$isPreview = Yii::$app->request->post('isPreview');
			$model->setAttributes($body, false);
			if($model->validate()) {
				if($isPreview) {
					try {
						$entity = \App::$domain->guide->article->oneByIdWithChapter($id);
					} catch(NotFoundHttpException $e) {
						$entity = \App::$domain->guide->factory->entity->create($this->id, ['id' => $id]);
					}
				} else {
					try{
						$entity = new ArticleEntity;
						$entity->id = $id;
						$entity->content = $body['content'];
						\App::$domain->guide->article->update($entity);
						\App::$domain->navigation->alert->create(['main', 'update_success'], Alert::TYPE_SUCCESS);
						return $this->redirect(NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_VIEW, compact('project_id', 'id')));
					} catch (UnprocessableEntityHttpException $e){
						$model->addErrorsFromException($e);
					}
				}
			}
		} else {
			try {
				$entity = \App::$domain->guide->article->oneByIdWithChapter($id);
			} catch(NotFoundHttpException $e) {
				$entity = \App::$domain->guide->factory->entity->create($this->id, ['id' => $id]);
			}
			$model->setAttributes($entity->toArray(), false);
		}
		if($id) {
			/** @var ArticleEntity $entity */
			$this->module->navigation->articleAndChapter($entity);
			$this->module->navigation->articleUpdate($entity);
		}
		return $this->render('update', ['model' => $model]);
	}

}
