<div id="user-profile-form">

  <div class="form-column-1">
    <?php print $account; ?>

    <?php print $locale; ?>
    <?php print $contact; ?>
    <?php print $signature_settings; ?> 
    <?php print $theme_select; ?>
  </div>
  
  <div class="form-column-2">
    <?php print $picture; ?>
    <?php print $personal_info; ?>
    <?php print $professional_info; ?>
    <?php print $block; ?>
    <?php print $user_titles; ?>
    <?php print $timezone; ?>
  </div>

</div>


<div class="submit-user-profile">
    <?php print $submit; ?>
    <?php print $delete; ?>
</div>

<?php print drupal_render($form); ?>
