<?php

namespace yii2module\guide\domain\services;

use Yii;
use yii\data\ArrayDataProvider;
use yii2lab\domain\BaseEntity;
use yii2lab\domain\services\base\BaseActiveService;
use yii2module\guide\domain\enums\GuidePermissionEnum;
use yii2module\guide\domain\repositories\file\ArticleRepository;

/**
 * Class ArticleService
 *
 * @package yii2module\guide\domain\services
 *
 * @property ArticleRepository $repository
 */
class ArticleService extends BaseActiveService {
	
	public function search($body) {
		$collection = $this->repository->search($body);
		$dataProvider = new ArrayDataProvider([
			'allModels' => $collection,
			'pagination' => false,
		]);
		return $dataProvider;
	}
	
	public function update(BaseEntity $entity) {
		\App::$domain->rbac->manager->can(GuidePermissionEnum::MODIFY, $this->repository->project);
		return $this->repository->update($entity);
	}

	public function oneMainByDir($dir) {
		return $this->repository->oneMainByDir($dir);
	}

	public function oneMain() {
		return $this->repository->oneMain();
	}

	public function oneByIdWithChapter($id) {
		return $this->repository->oneByIdWithChapter($id);
	}

	public function setProject($project_id) {
		return $this->repository->setProject($project_id);
	}

	public function getProject() {
		return $this->repository->project;
	}

}
