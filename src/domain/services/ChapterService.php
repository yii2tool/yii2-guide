<?php

namespace yii2module\guide\domain\services;

use Yii;
use yii2lab\domain\services\base\BaseActiveService;

class ChapterService extends BaseActiveService {

	public function oneByIdWithArticles($id) {
		return $this->repository->oneByIdWithArticles($id);
	}

}
