<?php

namespace yii2module\guide\domain\helpers;

use Yii;

class ArticleHelper {

	public static function extractTileFromMarkdown($code) {
		$code = strip_tags($code);
		$content = trim($code);
		$lines = preg_split('~(\n|\r\n)~', $content);
		$firstLine = $lines[0];
		return trim($firstLine, ' #');
	}

}
