<?php //print $user_profile;
  global $user; ?>
<?php // print '<pre>'. check_plain(print_r($profile, 1)) .'</pre>';
//var_dump($account);
//foreach ($account->content AS $key => $values) {
  //print ("<pre> $key => $values </pre>");
//}
/*
print '<pre>';
print_r(get_defined_vars());
print '</pre>';
*/
?>


  <div id="user-profile-form">
    <?php if ($profile[user_picture]) { print $profile[user_picture]; } ?>

    <div id="user-profile-about">
      <?php
        echo $profile_block_about;
      ?>
    </div>
  </div> <!-- user-profile-form -->

<?php
  // print $profile[summary];
  if ($user->uid == $account->uid) {
    if($edit_profile_link) {
      print $edit_profile_link;
    }
  }
?>



<?php
  echo $profile_block_content;
?>
