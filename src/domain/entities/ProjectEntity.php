<?php

namespace yii2module\guide\domain\entities;

use Yii;
use yii2lab\domain\BaseEntity;

class ProjectEntity extends BaseEntity {

	const DEFAULT_GROUP = 'main';

	protected $id;
	protected $owner;
	protected $name;
	protected $title;
	protected $dir;
	protected $main = 'README';
	protected $readonly = true;
	protected $group;

	public function getTitle() {
		if(!empty($this->title)) {
			return $this->title;
		}
		return BL . BL . BL . Yii::t('yii', '(not set)') . BL . BL . BL;
	}
}
