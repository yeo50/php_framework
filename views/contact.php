<?php

/** @var $model \app\models\ContactForm */ ?>
<h1>Contact</h1>
<?php $form = \app\core\form\Form::begin('', 'post') ?>
<?php echo $form->field($model, 'subject') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo new \app\core\form\TextareaField($model, 'body') ?>
<button type="submit" class="btn btn-primary mt-3">Submit</button>

<?php \app\core\form\Form::end(); ?>