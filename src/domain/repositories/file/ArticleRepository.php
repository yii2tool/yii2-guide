<?php

namespace yii2module\guide\domain\repositories\file;

use Yii;
use yii\web\NotFoundHttpException;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\data\Query;
use yii2lab\domain\interfaces\repositories\CrudInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2module\guide\domain\entities\ArticleEntity;
use yii2module\guide\domain\helpers\ArticleSearchHelper;

class ArticleRepository extends BaseRepository implements CrudInterface {

	public $project;
	public $main = 'README';
	
	public function search($body) {
		$projectCollection = \App::$domain->guide->project->all();
		$articleMap = ArticleSearchHelper::getArticleMap($projectCollection);
		$collection = ArticleSearchHelper::searchTextInArticleMap($articleMap, $body['text']);
		return $collection;
	}
	
	public function update(BaseEntity $entity) {
		$entity->validate();
		$project = \App::$domain->guide->project->oneById($this->project->id);
		$fileName = $project->dir . '/' . $entity->id . '.md';
		$fileName = ROOT_DIR . '/' . $fileName;
		FileHelper::save($fileName, $entity->content);
	}

	public function oneMainByDir($dir) {
		return $this->oneByDir($dir, $this->main);
	}

	public function oneByDir($dir, $id) {
		$content = FileHelper::load(Yii::getAlias("@{$dir}/{$id}.md"));
		if(empty($content)) {
			throw new NotFoundHttpException(__METHOD__ . ': ' . __LINE__);
		}
		return $this->forgeEntity([
			'id' => $id,
			'content' => $content,
		]);
	}

	public function setProject($project_id) {
		$project = \App::$domain->guide->project->oneById($project_id);
		$this->project = $project;
	}

	public function oneMain() {
		return $this->oneById($this->main);
	}

	public function oneById($id, Query $query = null) {
		/** @var Query $query */
		$content = FileHelper::load(Yii::getAlias("@{$this->project->dir}/{$id}.md"));
		//$query = Query::forge($query);
		if(empty($content)) {
			throw new NotFoundHttpException(__METHOD__ . ': ' . __LINE__);
		}
		$entity = $this->forgeEntity([
			'id' => $id,
			'content' => $content,
		]);
		$entity->project = $this->project;
		return $entity;
	}

	public function oneByIdWithChapter($id) {
		try {
			/** @var ArticleEntity $entity */
			$entity = $this->oneById($id);
		} catch(NotFoundHttpException $e) {
			$entity = \App::$domain->guide->factory->entity->create('article');
			$entity->id = $id;
		}
		try {
			$entity->chapter = $this->domain->repositories->chapter->oneByArticleId($id);
		} catch(NotFoundHttpException $e) {}
		return $entity;
	}
	
	/**
	 * @param BaseEntity $entity
	 *
	 * @throws \yii2lab\domain\exceptions\UnprocessableEntityHttpException
	 */
	public function insert(BaseEntity $entity) {
		// TODO: Implement insert() method.
	}
	
	/**
	 * @param BaseEntity $entity
	 *
	 */
	public function delete(BaseEntity $entity) {
		// TODO: Implement delete() method.
	}
	
	/**
	 * @param Query|null $query
	 *
	 * @return array|null
	 */
	public function all(Query $query = null) {
		// TODO: Implement all() method.
	}
	
	/**
	 * @param Query|null $query
	 *
	 * @return integer
	 */
	public function count(Query $query = null) {
		// TODO: Implement count() method.
	}
}
