<?php

/* @var $this yii\web\View */

use yii2lab\extension\web\helpers\Page;
use yii2lab\extension\yii\helpers\Html;
use yii2module\guide\domain\entities\ProjectEntity;
use yii2module\guide\module\helpers\NavigationHelper;
use yii2lab\extension\markdown\widgets\Markdown;
use yii2module\guide\domain\enums\GuidePermissionEnum;
use yii2lab\extension\markdown\widgets\helpers\ArticleMenuHelper;
use yii2lab\extension\markdown\widgets\helpers\MarkdownHelper;

$this->title = $entity->title;

$html = Markdown::widget(['content' => $entity->content]);

if(!$entity->is_main && is_object($entity->project) && !$entity->project->readonly) {
	$menu = ArticleMenuHelper::getMenuFromHtml($html);
	if(!empty($menu)) {
		$html = ArticleMenuHelper::addIdInHeaders($html);
	}
	$menuMd = ArticleMenuHelper::makeMenuMd($menu);
	$menuHtml = MarkdownHelper::toHtml($menuMd);
	$html = str_replace('</h1>', '</h1>' . $menuHtml . PHP_EOL, $html);
}

?>

<div class="pull-right">

<?php
if($entity->project instanceof ProjectEntity) {
	$packageName = str_replace(DOT, SL, $entity->project->id);
	echo Html::a(Html::fa('github', ['class' => 'text-primary']), "https://github.com/{$packageName}/blob/master/guide/ru/{$entity->id}.md", [
		'title' => Yii::t('guide/article', 'view_in_github'),
		'target' => '_blank',
	]);
	echo NBSP;
}
echo Html::a(Html::fa('code', ['class' => 'text-primary']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_CODE, ['id' => $entity->id]), [
	'title' => Yii::t('action', 'code'),
]);
echo NBSP;
if(Yii::$app->user->can(GuidePermissionEnum::MODIFY, $entity->project)) {
	echo Html::a(Html::fa('pencil', ['class' => 'text-primary']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_UPDATE, ['id' => $entity->id]), [
		'title' => Yii::t('action', 'update'),
	]);
	echo NBSP;
	echo Html::a(Html::fa('trash', ['class' => 'text-danger']), NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_DELETE, ['id' => $entity->id]), [
		'title' => Yii::t('action', 'delete'),
		'data' => [
			'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
			'method' => 'post',
		],
	]);
}
?>
<?= NBSP ?>
<?= Page::snippet('search_button', '@yii2module/guide/module') ?>
</div>

<?= $html ?>

<br/>
