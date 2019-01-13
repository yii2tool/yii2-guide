<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii2lab\navigation\domain\widgets\Alert;
use yii2module\guide\module\helpers\NavigationHelper;
use yii2module\guide\domain\enums\GuidePermissionEnum;

$this->title = Yii::t('guide/article', 'title');
$url = NavigationHelper::genUrl(NavigationHelper::URL_ARTICLE_UPDATE, compact('id'));
\App::$domain->navigation->alert->create(['guide/article', 'not_found'], Alert::TYPE_DANGER, null);
$buttonVisibleClass = !Yii::$app->user->can(GuidePermissionEnum::MODIFY) ? 'hidden' : '';
?>

<?= Html::a(Yii::t('action', 'create'), $url, [
		'class' => 'btn btn-primary ' . $buttonVisibleClass,
	]) ?>
<br/>
