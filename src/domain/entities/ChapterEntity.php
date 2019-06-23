<?php

namespace yii2tool\guide\domain\entities;

use yii2rails\domain\BaseEntity;

class ChapterEntity extends BaseEntity {

	protected $id;
	protected $title;
	protected $parent_id;
	protected $parent;
	protected $articles;

	public function fieldType() {
		return [
			'parent' => [
				'type' => static::class,
			],
			'articles' => [
				'type' => ArticleEntity::class,
				'isCollection' => true,
			],
		];
	}
}