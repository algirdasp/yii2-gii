<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update ' . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ':') ?> . ' ' . <?= $generator->modelClass ?>::byIdAsString($model->id);
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => <?= $generator->modelClass . '::byIdAsString($model->id)' ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    
    <p class="actions">
        <?= "<?= " ?>Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . <?= $generator->generateString('View') ?>, ['view', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a('<span class="glyphicon glyphicon-trash"></span> ' . <?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this ' . Inflector::camel2words(StringHelper::basename($generator->modelClass)) . '?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </p>    

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
