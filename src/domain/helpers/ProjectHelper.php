<?php

namespace yii2module\guide\domain\helpers;

use Yii;
use yii\web\NotFoundHttpException;
use yii2module\guide\domain\entities\ProjectEntity;

class ProjectHelper {

	public static function normalizeItem($item) {
		$item['id'] = self::getId($item);
		$item['dir'] = self::getDir($item);
		$item['group'] = self::getGroup($item);
		$item['title'] = self::getTitle($item);
		return $item;
	}
	
	private static function getDir($item) {
		if(!empty($item['dir'])) {
			return $item['dir'];
		}
		$alias = 'vendor' . SL . $item['package'] . SL . 'guide/ru';
		return $alias;
	}
	
	private static function getId($item) {
		if(!empty($item['id'])) {
			return $item['id'];
		}
		if(!empty($item['package'])) {
			return str_replace(SL,DOT, $item['package']);
		}
		return serialize($item);
	}
	
	private static function getGroup($item) {
		if(!empty($item['group'])) {
			return $item['group'];
		}
		if(!empty($item['owner'])) {
			return $item['owner'];
		}
		return ProjectEntity::DEFAULT_GROUP;
	}
	
	private static function getTitle($item) {
		if(!empty($item['title'])) {
			return $item['title'];
		}
		try {
			$article = \App::$domain->guide->article->oneMainByDir($item['dir']);
			return ArticleHelper::extractTileFromMarkdown($article->content);
		} catch(NotFoundHttpException $e) {
			return null;
		}
	}
}
