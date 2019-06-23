<?php

namespace yii2tool\guide\domain\repositories\file;

use yii2rails\domain\data\Query;
use yii2rails\domain\interfaces\repositories\ReadInterface;
use yii2rails\domain\repositories\BaseRepository;
use yii2rails\extension\arrayTools\traits\ArrayReadTrait;
use yii2tool\guide\domain\helpers\ChapterHelper;

class ChapterRepository extends BaseRepository implements ReadInterface {

	use ArrayReadTrait;

	public $primaryKey = 'id';

	public function oneByIdWithArticles($id) {
		$entity = $this->oneById($id);
		$entity->articles = $this->allByParentId($id);
		return $entity;
	}

	public function oneByArticleId($id) {
		$entity = $this->oneById($id);
		$entity->parent = $this->oneById($entity->parent_id);
		return $entity;
	}

	protected function allByParentId($id) {
		$query = Query::forge();
		$query->where('parent_id', $id);
		$collection = $this->all($query);
		return $collection;
	}

	protected function getCollection() {
		$main = $this->domain->repositories->article->oneMain();
		return ChapterHelper::extractAll($main->content);
	}
}
