<!--/there can't be a space between the input field and the button or IE adds unwanted margins -->
<div class="container-inline">
<input type="text" maxlength="128" name="search_theme_form" id="edit-search-theme-form-1" size="25" value="" title="Enter the terms you wish to search for." class="form-text" /><input type="image" src="<?php print base_path() . path_to_theme() ?>/images/search.gif" name="op" id="edit-submit-button" value="Search" title="Search" class="form-submit" />
   <input type="hidden" name="form_build_id" id="<?php print drupal_get_token('form_build_id'); ?>" value="<?php print drupal_get_token('form_build_id'); ?>"  />
<input type="hidden" name="form_token" id="edit-search-theme-form-form-token" value="<?php print drupal_get_token('search_theme_form');?>"  />
<input type="hidden" name="form_id" id="edit-search-theme-form" value="search_theme_form"  />
</div>
