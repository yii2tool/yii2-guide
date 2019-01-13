<?php

namespace yii2module\guide\module\helpers;

class ViewHelper {

	public static function collectionToMap($collection) {
		$map = [];
		foreach($collection as $entity) {
			$map[$entity->group][] = $entity;
		}
		return $map;
	}

	public static function collectionToItems($collection, $url, $key = 'id') {
		$items = [];
		foreach($collection as $item) {
			if(is_array($key)) {
				$urlArray[$key[0]] = $item->{$key[1]};
			} else {
				$urlArray[$key] = $item->id;
			}
			$items[] = [
				'label' => $item->title,
				'url' => NavigationHelper::genUrl($url, $urlArray),
			];
		}
		return $items;
	}

}
