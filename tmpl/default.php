<?php

defined('_JEXEC') or die; ?>

<?php if (isset($validator) && ! $validator->errors()) :?>
    <div class="alert alert-success" role="alert">
        <?php echo JText::_('MOD_HARMAC_CONTACT_FORM_FRONT_SENDING_SUCCESS'); ?>
    </div>
<?php endif; ?>

<?php
    $form = new FormBuilder();
    $labelsAboveInput = $labelsPlacement === 'above_input';
?>
<?php echo $form->open($action); ?>
<div class="form-group <?php echo isset($validator) && $validator->hasError('name') ? 'has-error' : ''; ?>">
    <?php echo ($labelsAboveInput) ? $form->label($labels['name'], ['for' => 'name']) : ''; ?>
    <?php echo $form->text('name', $name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => ( ! $labelsAboveInput) ? $labels['name'] : '']); ?>
    <?php if (isset($validator) && $validator->hasError('name')) : ?>
        <span class="help-block"><?php echo $validator->error('name'); ?></span>
    <?php endif; ?>
</div>
<div class="form-group <?php echo isset($validator) && $validator->hasError('email') ? 'has-error' : ''; ?>">
    <?php echo ($labelsAboveInput) ? $form->label($labels['email'], ['for' => 'email']) : ''; ?>
    <?php echo $form->text('email', $email, ['id' => 'email', 'class' => 'form-control', 'placeholder' => ( ! $labelsAboveInput) ? $labels['email'] : '']); ?>
    <?php if (isset($validator) && $validator->hasError('email')) : ?>
        <span class="help-block"><?php echo $validator->error('email'); ?></span>
    <?php endif; ?>
</div>
<?php if ($isPhoneFieldActive) : ?>
    <div class="form-group">
        <?php echo ($labelsAboveInput) ? $form->label($labels['phone'], ['for' => 'phone']) : ''; ?>
        <?php echo $form->text('phone', $phone, ['id' => 'phone', 'class' => 'form-control', 'placeholder' => ( ! $labelsAboveInput) ? $labels['phone'] : '']); ?>
    </div>
<?php endif; ?>
<div class="form-group <?php echo isset($validator) && $validator->hasError('message') ? 'has-error' : ''; ?>">
    <?php echo ($labelsAboveInput) ? $form->label($labels['message'], ['for' => 'message']) : ''; ?>
    <?php echo $form->textarea('message', $phone, ['id' => 'message', 'class' => 'form-control', 'placeholder' => ( ! $labelsAboveInput) ? $labels['message'] : '']); ?>
    <?php if (isset($validator) && $validator->hasError('message')) : ?>
        <span class="help-block"><?php echo $validator->error('message'); ?></span>
    <?php endif; ?>
</div>
<div class="form-group">
    <?php echo $form->button($labels['submit'], ['class' => 'btn btn-default']); ?>
</div>
<?php echo $form->close(); ?>