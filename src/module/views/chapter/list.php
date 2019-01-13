<?php

/* @var $this yii\web\View */

use yii\widgets\Menu;
use yii2module\guide\module\helpers\NavigationHelper;
use yii2module\guide\module\helpers\ViewHelper;

$this->title = $entity->title;
?>

<h1>
	<?= $entity->title ?>
</h1>

<?= Menu::widget([
	'items' => ViewHelper::collectionToItems($entity->articles, NavigationHelper::URL_ARTICLE_VIEW)
]) ?>

<br/>
