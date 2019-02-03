<?php

namespace yii2module\guide\domain;

use yii2rails\domain\enums\Driver;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class Domain
 * 
 * @package yii2module\guide\domain
 * @property-read \yii2module\guide\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2rails\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'project' => Driver::FILE,
				'article' => Driver::FILE,
				'chapter' => Driver::FILE,
			],
			'services' => [
				'project' => BaseActiveService::class,
				'article',
				'chapter',
			],
		];
	}
	
}
