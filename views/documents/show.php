<?php if($user->super_admin == 1):?>
<?php $this->widget('application.modules.documents.widgets.DocumentsFormWidget', array('contentContainer' => $this->getSpace())); ?>
<?php endif;?>
<?php $this->widget('application.modules.documents.widgets.DocumentsStreamWidget', array('contentContainer' => $this->getSpace())); ?>