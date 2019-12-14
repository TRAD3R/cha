<?php
?>
<table>
        <?php echo $this->render('table_head'); ?>
        
        <?php echo $this->render('table_body', compact('devices')); ?>
</table>