<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Тестовое задание';
?>

<div class="row">
	<div class="filter-form col-md-3 order-md-1 mb-4">
		<?php $form = ActiveForm::begin([
			'id' => 'filter-form',
			'fieldConfig' => [
				'template' => "{input}",
				'options' => [
					'tag' => false
				]
			]
		]); ?>
		
		<div class="row filter-form__label-wrapper">
			<div class="col-md-6 filter-form__label">Площадь от</div>
			<div class="col-md-5 filter-form__label">до, м<sup>2</sup></div>
		</div>
		<div class="row range-selector" data-min="<?= $oFilterForm->aRanges['MIN(iArea)'] ?>" data-max="<?= $oFilterForm->aRanges['MAX(iArea)'] ?>">
		    <?= $form->field($oFilterForm, 'iMinArea')->textInput(["class" => "filter-form__input range-selector__min col-md-5"]) ?>
		    <div class="col-md-1 filter-form__separator">-</div>
		    <?= $form->field($oFilterForm, 'iMaxArea')->textInput(["class" => "filter-form__input range-selector__max col-md-5"]) ?>
		</div>
		<div class="row filter-form__label-wrapper">
			<div class="col-md-6 filter-form__label">Ставка от</div>
			<div class="col-md-5 filter-form__label">до, руб./м<sup>2</sup>/год</div>
		</div>
		<div class="row range-selector" data-min="<?= $oFilterForm->aRanges['MIN(iPricePerYear)'] ?>" data-max="<?= $oFilterForm->aRanges['MAX(iPricePerYear)'] ?>">
		    <?= $form->field($oFilterForm, 'iMinPricePerYear')->textInput(["class" => "filter-form__input range-selector__min col-md-5"]) ?>
		    <div class="col-md-1 filter-form__separator">-</div>
		    <?= $form->field($oFilterForm, 'iMaxPricePerYear')->textInput(["class" => "filter-form__input range-selector__max col-md-5"]) ?>
		</div>

	    <div class="row">
	        <?= Html::submitButton('Найти', ['class' => 'filter-form__submit col-md-11']) ?>
	    </div>
		
		<div class="row filter-form__block">
			<div class="col-md-11">
				<div class="filter-form__block-label-1">ЭТАЖ</div>
				<div class="filter-form__block-label-2">от <?= $oFilterForm->iMinFloor ?> до <?= $oFilterForm->iMaxFloor ?></div>
			</div>
		</div>
		<div class="row range-selector floor-selector" data-min="<?= $oFilterForm->aRanges['MIN(iFloor)'] ?>" data-max="<?= $oFilterForm->aRanges['MAX(iFloor)'] ?>">
		    <?= $form->field($oFilterForm, 'iMinFloor')->textInput(["class" => "hidden range-selector__min"]) ?>
		    <?= $form->field($oFilterForm, 'iMaxFloor')->textInput(["class" => "hidden range-selector__max"]) ?>
		</div>

		<?php ActiveForm::end(); ?>
		<div class="bottom-line"></div>
	</div>
	<div class="objects-list col-md-9 order-md-2">

	</div>
</div>