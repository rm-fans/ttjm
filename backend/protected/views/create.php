<?php
/* @var $this projectModelController */
/* @var $model projectModel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-model-create-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buy_method_id'); ?>
		<?php echo $form->textField($model,'buy_method_id'); ?>
		<?php echo $form->error($model,'buy_method_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'disposition_end_at'); ?>
		<?php echo $form->textField($model,'disposition_end_at'); ?>
		<?php echo $form->error($model,'disposition_end_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'view_count'); ?>
		<?php echo $form->textField($model,'view_count'); ?>
		<?php echo $form->error($model,'view_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'service_uid'); ?>
		<?php echo $form->textField($model,'service_uid'); ?>
		<?php echo $form->error($model,'service_uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->textField($model,'uid'); ?>
		<?php echo $form->error($model,'uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'market_price'); ?>
		<?php echo $form->textField($model,'market_price'); ?>
		<?php echo $form->error($model,'market_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount_rate'); ?>
		<?php echo $form->textField($model,'discount_rate'); ?>
		<?php echo $form->error($model,'discount_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sell_total_price'); ?>
		<?php echo $form->textField($model,'sell_total_price'); ?>
		<?php echo $form->error($model,'sell_total_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sell_unit_price'); ?>
		<?php echo $form->textField($model,'sell_unit_price'); ?>
		<?php echo $form->error($model,'sell_unit_price'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->