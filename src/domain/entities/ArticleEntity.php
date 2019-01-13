<?php

namespace yii2module\guide\domain\entities;

use Yii;
use yii\helpers\Inflector;
use yii2lab\domain\BaseEntity;
use yii2module\guide\domain\helpers\ArticleHelper;

/**
 * Class ArticleEntity
 *
 * @package yii2module\guide\domain\entities
 *
 * @property integer $id
 * @property string $content
 * @property ChapterEntity|null $chapter
 * @property ProjectEntity|null $project
 */
class ArticleEntity extends BaseEntity {
	
	protected $id;
	protected $content;
	protected $chapter;
	protected $project;

	public function rules()
	{
		return [
			['id', 'required'],
			['id', 'match', 'pattern' => '/^[a-z-]+$/i']
		];
	}

	public function fieldType() {
		return [
			'chapter' => [
				'type' => ChapterEntity::class,
			],
			'project' => [
				'type' => ProjectEntity::class,
			],
		];
	}

	public function getIsMain() {
		return $this->id == \App::$domain->guide->repositories->article->main;
	}

	public function getTitle() {
		if(!empty($this->content)) {
			return ArticleHelper::extractTileFromMarkdown($this->content);
		}
		if(!empty($this->id)) {
			$title = Inflector::id2camel($this->id);
			$title = Inflector::camel2words($title);
			$title = ucfirst($title);
			return $title;
		}
	}

	public function getContent() {
		if(!empty($this->content)) {
			return $this->content;
		}
		$title = $this->getTitle();
		if(!empty($title)) {
			return $title . PHP_EOL . '===' . PHP_EOL;
		}
	}
}