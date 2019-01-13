<?php

namespace yii2module\guide\module;

use Yii;
use yii\base\Module as YiiModule;
use yii2lab\domain\helpers\DomainHelper;
use yii2module\guide\module\helpers\NavigationHelper;

class Module extends YiiModule
{

	public $navigation;
	
	public function init() {
		DomainHelper::forgeDomains([
			'vendor' => 'yii2module\vendor\domain\Domain',
			'guide' => 'yii2module\guide\domain\Domain',
		]);
		parent::init();
		$this->initNavigation();
		$this->initProject();
	}

	private function initNavigation() {
		$this->navigation = Yii::createObject(NavigationHelper::class);
		$this->navigation->root();
	}

	private function initProject() {
		$project_id = Yii::$app->request->getQueryParam('project_id');
		if($project_id) {
			\App::$domain->guide->article->setProject($project_id);
			$this->navigation->project($project_id);
		}
	}
}
