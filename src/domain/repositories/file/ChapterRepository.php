<?php

namespace yii2module\guide\domain\repositories\file;

use yii2lab\domain\data\Query;
use yii2lab\domain\interfaces\repositories\ReadInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\extension\arrayTools\traits\ArrayReadTrait;
use yii2module\guide\domain\helpers\ChapterHelper;

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
