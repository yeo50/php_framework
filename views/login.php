<?php

/** @var $model \app\models\User */
?>


<h1>Login</h1>
<?php $form =  \app\core\form\Form::begin('', 'post') ?>

<?php echo $form->field($model, 'email'); ?>
<?php echo $form->field($model, 'password')->passwordField(); ?>

<button type="submit" class="btn btn-primary mt-3">Submit</button>
<?php \app\core\form\Form::end() ?>