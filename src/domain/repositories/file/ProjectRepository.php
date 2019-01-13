<?php

namespace yii2module\guide\domain\repositories\file;

use yii\helpers\ArrayHelper;
use yii2lab\extension\arrayTools\repositories\base\BaseActiveDiscRepository;
use yii2module\guide\domain\helpers\ProjectHelper;

class ProjectRepository extends BaseActiveDiscRepository {

	public $owners = [];
	public $table = 'project';
	public $path = '@yii2module/guide/data';

	protected function getCollection() {
		$array = parent::getCollection();
		$packageArray = $this->findProjects();
		$array = ArrayHelper::merge($array, $packageArray);
		$newArray = [];
		foreach($array as $item) {
			$item = ProjectHelper::normalizeItem($item);
			if(!isset($item['readonly'])) {
				$item['readonly'] = !empty($this->owners) && !empty($item['owner']) && !in_array($item['owner'], $this->owners);
			}
			if(!empty($item['title']) || empty($item['hide_on_null'])) {
				$newArray[] = $item;
			}
		}
		return $newArray;
	}
	
	private function findProjects() {
		$map = \App::$domain->vendor->info->allWithGuide();
		$projects = ArrayHelper::getColumn($map, function ($entity) {
			return [
				'owner' => $entity->owner,
				'name' => $entity->name,
				'package' => $entity->package,
			];
		});
		return $projects;
	}
	
}
