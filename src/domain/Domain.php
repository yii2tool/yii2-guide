<?php

namespace yii2module\guide\domain;

use yii2lab\domain\enums\Driver;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class Domain
 * 
 * @package yii2module\guide\domain
 * @property-read \yii2module\guide\domain\interfaces\repositories\RepositoriesInterface $repositories
 */
class Domain extends \yii2lab\domain\Domain {
	
	public function config() {
		return [
			'repositories' => [
				'project' => [
					'driver' => Driver::FILE,
					'owners' => [
                        'yii2bundle',
						/*'yii2lab',
						'yii2module',
						'yii2guide',*/
					],
				],
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
