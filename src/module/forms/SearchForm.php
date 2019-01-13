<?php

namespace yii2module\guide\module\forms;

use Yii;
use yii2lab\domain\base\Model;

class SearchForm extends Model
{
	
	public $text;
	
	public function rules() {
		return array_merge(parent::rules(), [
			[['text'], 'required'],
		]);
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'text' 		=> Yii::t('guide/search', 'text'),
		];
	}
	
}
