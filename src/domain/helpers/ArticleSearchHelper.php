<?php

namespace yii2module\guide\domain\helpers;

use Yii;
use yii2lab\extension\common\helpers\StringHelper;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2module\guide\domain\entities\ArticleEntity;
use yii2module\guide\domain\entities\ProjectEntity;
use yii\helpers\ArrayHelper;

class ArticleSearchHelper {
	
	/**
	 * @param $projectCollection ProjectEntity[]
	 *
	 * @return ArticleEntity[]
	 */
	public static function getArticleMap($projectCollection) {
		$finded = [];
		foreach($projectCollection as $projectEntity) {
			$dir = FileHelper::getAlias('@' . $projectEntity->dir);
			if(FileHelper::has($dir)) {
				$files = self::findArticleNames($dir);
				$finded[$projectEntity->id] = $files;
			}
		}
		return $finded;
	}
	
	/**
	 * @param $articleMap array
	 * @param $text string
	 *
	 * @return array
	 */
	public static function searchTextInArticleMap($articleMap, $text) {
		$collection = [];
		foreach($articleMap as $projectId => $articleNames) {
			$articleCollection = self::findInProject($projectId, $articleNames, $text);
			$collection = ArrayHelper::merge($collection, $articleCollection);
		}
		return $collection;
	}
	
	protected static function findInProject($projectId, $articleNames, $text) {
		$articleCollection = [];
		$projectEntity = \App::$domain->guide->project->oneById($projectId);
		\App::$domain->guide->article->setProject($projectId);
		foreach($articleNames as $articleId) {
			$articleEntity = \App::$domain->guide->article->oneByIdWithChapter($articleId);
			$isExists = StringHelper::search($articleEntity->content, $text);
			$articleEntity->project = $projectEntity;
			if($isExists) {
				$articleCollection[] = $articleEntity;
			}
		}
		return $articleCollection;
	}
	
	protected static function findArticleNames($dir) {
		$files = self::findMdFiles($dir);
		$files = self::removeRootPathAndExt($files, $dir);
		return $files;
	}
	
	protected static function removeRootPathAndExt($files, $dir) {
		foreach($files as &$file) {
			$file = mb_substr($file, mb_strlen($dir) + 1, -3);
		}
		return $files;
	}
	
	protected static function findMdFiles($dir) {
		$options['only'][] = '*.md';
		return FileHelper::findFiles($dir, $options);
	}
	
}
