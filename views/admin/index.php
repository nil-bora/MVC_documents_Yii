
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('DocumentsModule.base', 'Folders'); ?></div>
    <div class="panel-body">

        <?php echo HHtml::link(Yii::t('PagesModule.base', 'Create new Folder'), $this->createUrl('edit'), array('class' => 'btn btn-primary')); ?>

        <p />
        <p />


        <?php if (count($pages) != 0): ?>
            <?php
    	        $classes = Page::getNavigationClasses();
	            $types = Page::getPageTypes();
            ?>
            <table class="table">
                <tr>
                    <th><?php echo Yii::t('PagesModule.base', 'Title'); ?></th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?php echo HHtml::link($page->name, $this->createUrl('edit', array('id' => $page->id))); ?></td>

                        <td><?php echo HHtml::link('Edit', $this->createUrl('edit', array('id' => $page->id)), array('class' => 'btn btn-primary btn-xs pull-right')); ?></td>
                    </tr>

                <?php endforeach; ?>
            </table>

        <?php else: ?>

            <p><?php echo Yii::t('PagesModule.base', 'No pages created yet!'); ?></p>


        <?php endif; ?>

    </div>
</div>


