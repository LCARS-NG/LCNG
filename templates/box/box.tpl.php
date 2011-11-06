<?php
// $Id: box.tpl.php 1 2010-08-01 17:41:27Z root $

/**
 * @file box.tpl.php
 * Theme implementation to display a box.
 *
 * Available variables:
 * - $title: Box title.
 * - $content: Box content.
 *
 * @see template_preprocess()
 */
?>
<div class="box">
  <div class="box-inner">
    <?php if ($title): ?>
      <h2 class="box-title"><?php print $title ?></h2>
    <?php endif; ?>
    <div class="box-content">
      <?php print $content ?>
    </div>
  </div>
</div> <!-- /box -->