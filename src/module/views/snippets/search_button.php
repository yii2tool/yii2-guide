<?php

use yii\helpers\Url;
use yii2lab\extension\yii\helpers\Html;

?>

<?=  Html::a(Html::fa('search', ['class' => 'text-primary']), Url::to(['/guide/search']), [
        'class' => 'pull-right',
	'title' => Yii::t('action', 'search'),
]) ?>
