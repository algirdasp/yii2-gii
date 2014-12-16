<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <p class="actions">
        <?= "<?= " ?>Html::a('<span class="glyphicon glyphicon-plus"></span> ' . <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
        <?= "<?= " ?>Html::a('<span class="glyphicon glyphicon-search"></span> ' . <?= $generator->generateString('Search') ?>, ['#'], ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#searchModal']) ?>
    </p>
    
<?php if(!empty($generator->searchModelClass)): ?>    
    <?="<?php\n"?>
        yii\bootstrap\Modal::begin([
            'header' => Yii::t('app', 'Search'),
            'id' => 'searchModal'
        ]);
        
        echo $this->render('_search', [
            'model' => $searchModel
        ]);
        
        yii\bootstrap\Modal::end();     
    ?>    
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            [\n\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t'value' => function(\$item) {\n\t\t\t\t\treturn \$item->" . $column->name . ";\n\t\t\t\t}," . ($format === 'text' ? "" : "\n\t\t\t\t'format' => '" . $format . "'") . "\n\t\t\t],\n";
        } else {
            echo "            /*[\n\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t'value' => function(\$item) {\n\t\t\t\t\treturn \$item->" . $column->name . ";\n\t\t\t\t}," . ($format === 'text' ? "" : "\n\t\t\t\t'format' => '" . $format . "'") . "\n\t\t\t],*/\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

</div>
