
<div class="panel panel-default">
    <?php if (!$page->isNewRecord) : ?>
        <div class="panel-heading"><?php echo Yii::t('Pages.views_admin_edit', '<strong>Edit</strong> page'); ?></div>
    <?php else: ?>
        <div class="panel-heading"><?php echo Yii::t('Pages.views_admin_edit', '<strong>Create</strong> page'); ?></div>
    <?php endif; ?>
    <div class="panel-body">

        <?php
        $form = $this->beginWidget('HActiveForm', array(
            'id' => 'page-edit-form',
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php //echo $form->errorSummary($page); ?>

        <div class="form-group">
            <?php echo $form->labelEx($page, 'name'); ?>
            <?php echo $form->textField($page, 'name', array('class' => 'form-control', 'placeholder' => Yii::t('Pages.views_admin_edit', 'Page title'))); ?>
        </div>


        

        <?php echo CHtml::submitButton(Yii::t('Pages.views_admin_edit', 'Save'), array('class' => 'btn btn-primary')); ?>

        <?php
        if (!$page->isNewRecord) {
            echo CHtml::link(Yii::t('Pages.views_admin_edit', 'Delete'), $this->createUrl('//documents/admin/delete', array('id' => $page->id)), array('class' => 'btn btn-danger'));
        }
        ?>

        <?php $this->endWidget(); ?>

    </div>
</div>

<script>

    if ($("#page_type").val() == '1' || $("#page_type").val() == '3') {
        $("#content_field").hide();
    } else {
        $("#url_field").hide();
    }

    $("#page_type").change(function() {
        if ($("#page_type").val() == '1' || $("#page_type").val() == '3') {
            $("#content_field").hide();
            $("#url_field").show();
        } else {
            $("#url_field").hide();
            $("#content_field").show();
        }
    });


</script>    