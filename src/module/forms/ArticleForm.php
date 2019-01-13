<?php

namespace yii2module\guide\module\forms;

use Yii;
use yii2lab\domain\base\Model;

class ArticleForm extends Model
{
	
	public $id;
	public $content;

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 		=> Yii::t('guide/article', 'id'),
			'content' 		=> Yii::t('guide/article', 'content'),
		];
	}
	
}
