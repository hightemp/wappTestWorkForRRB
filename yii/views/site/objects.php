<?php

use yii\helpers\Html;

?>

<script>
	var iNumberOfPages = <?= $oPages->getPageCount() ?>;
</script>

<? foreach ($aObjects as $oObject): ?>
<div class="object-item row">
	<div class="col-md-2 order-md-1">
		<?= Html::img("@web/files/{$oObject->sImageFileName}") ?>
	</div>
	<div class="col-md-10 order-md-2">
		<div class="object-item__name"><?= $oObject->sName ?></div>
		<div class="object-item__address"><?= $oObject->sAddress ?></div>
		
		<div class="blocks-list">
			<? foreach ($oObject->getBlocks($oFilterForm) as $oBlock): ?>
			<div class="blocks-item">
				<div class="row">
					<div class="blocks-item__title col-md-12">Аренда офиса <b>·</b><span><?= $oBlock->iFloor ?> этаж</span></div>
				</div>
				<div class="row blocks-item__block">
					<div class="blocks-item__area col-md-2 order-md-1"><?= $oBlock->iArea ?> м<sup>2</sup></div>
					<div class="blocks-item__price-1 col-md-5 order-md-2"><b><?= number_format($oBlock->iPricePerYear, 0, ".", " ") ?></b> руб./м<sup>2</sup> в год</div>
					<div class="blocks-item__price-2 col-md-5 order-md-3"><b><?= number_format($oBlock->iPricePerMonth, 0, ".", " ") ?></b> руб./мес</div>
				</div>
			</div>
			<? endforeach ?>
		</div>
	</div>
</div>
<? endforeach ?>