<?php global $user; ?>

  <div id="user-profile-form">
    <?php if ($profile[user_picture]) { print $profile[user_picture]; } ?>

    <div id="user-profile-about">
      <?php
        echo $profile_block_about;
      ?>
    </div>
  </div> <!-- user-profile-form -->

<?php
  print $profile[summary];
  if ($user->uid == $account->uid) {
    if($edit_profile_link) {
      print $edit_profile_link;
    }
  }
?>

