<?php

namespace yii2tool\guide\domain\services;

use Yii;
use yii2rails\domain\services\base\BaseActiveService;

class ChapterService extends BaseActiveService {

	public function oneByIdWithArticles($id) {
		return $this->repository->oneByIdWithArticles($id);
	}

}
