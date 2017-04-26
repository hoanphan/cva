<?php
/**
 * Created by PhpStorm.
 * User: HOANDHTB
 * Date: 8/31/2016
 * Time: 2:55 PM
 */
use kartik\builder\TabularForm;
use kartik\form\ActiveForm;
use kartik\grid\GridView;
use kartik\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id' => 'form2',

]) ?>
    <div class="col-xs-12" id="grid">
        <?php

        echo TabularForm::widget([
            'dataProvider' => $dataProvider,
            'form' => $form,
            'actionColumn' => false,

            'checkboxColumn' => false,
            'attributes' => $collum,
            'gridSettings' => [
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'floatHeader' => true,
                'pjax' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Danh sách điểm</h3>',
                    'type' => GridView::TYPE_PRIMARY,

                ]
            ]
        ]);
        ?>
    </div>
<?php ActiveForm::end() ?>