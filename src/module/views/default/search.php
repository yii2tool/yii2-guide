<?php

/* @var $this yii\web\View
 * @var $collection array */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('action', 'search');

$drawLink = function ($articleEntity) {
	//$projectUrl = Url::to(['/guide/article', 'project_id' => $articleEntity->project->id]);
	//$links[] = Html::a($articleEntity->project->title, $projectUrl, ['target' => '_blank']);
	$links[] = Html::tag('span', $articleEntity->project->title, ['class' => 'text-muted']);
	if(is_object($articleEntity->chapter)) {
		//$chapterUrl = Url::to(['/guide/chapter/view', 'project_id' => $articleEntity->project->id, 'id' => $articleEntity->chapter->parent->id]);
		//$links[] = Html::a($articleEntity->chapter->parent->title, $chapterUrl, ['target' => '_blank']);
		$links[] = Html::tag('span', $articleEntity->chapter->parent->title, ['class' => 'text-muted']);
	}
	$articleUrl = Url::to(['/guide/article/view', 'project_id' => $articleEntity->project->id, 'id' => $articleEntity->id]);
	$links[] = Html::a($articleEntity->title, $articleUrl, ['target' => '_blank']);
	$glue = '&nbsp; <span class="text-muted">/</span> &nbsp;';
	return implode($glue, $links);
};

?>

<div class="row">
    <div class="col-lg-12">
    
		<?php $form = ActiveForm::begin(); ?>
	
	    <?= $form->field($model, 'text')->textInput(['maxlength' => 64]) ?>

        <div class="form-group">
			<?= Html::submitButton(Yii::t('action', 'search'), ['class' => 'btn btn-primary']) ?>
        </div>
	
	    <?php ActiveForm::end(); ?>

        <?php
        if($dataProvider) {
	        $columns = [
		        [
			        'format' => 'raw',
			        'value' => $drawLink,
		        ],
	        ];
	        echo GridView::widget([
		        'dataProvider' => $dataProvider,
		        'layout' => '<span class="pull-right">{summary}</span>{items}',
		        'columns' => $columns,
		        'tableOptions' => ['class' => ''],
	        ]);
        }
	    ?>
	
    </div>
</div>

<br/>
