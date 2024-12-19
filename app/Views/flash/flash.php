<?php if (session()->getFlashData('success')) : ?>
<div class="flash-data" data-flashsuccess="<?= session()->getFlashData('success'); ?>"></div>
<?php elseif (session()->getFlashData('info')) : ?>
<div class="flash-data" data-flashinfo="<?= session()->getFlashData('info'); ?>"></div>
<?php elseif (session()->getFlashData('warning')) : ?>
<div class="flash-data" data-flashwarning="<?= session()->getFlashData('warning'); ?>"></div>
<?php elseif (session()->getFlashData('login')) : ?>
<div class="flash-data" data-flashlogin="<?= session()->getFlashData('login'); ?>"></div>
<?php else : ?>
<div class="flash-data" data-flasherror="<?= session()->getFlashData('error'); ?>"></div>
<?php endif; ?>
