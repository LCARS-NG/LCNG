<?php

/**
 * @file template.php
 */

/**
 * USAGE
 * 1. Rename each function to match your DARKs name,
 *    e.g. if you name your theme genesis_foo then the function
 *    name will be "genesis_foo_preprocess".
 * 2. Uncomment the required fucntion to use. You can delete the
 *    "sample_variable".
 */

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered.
 */


function LCNG_preprocess_page(&$vars) {
  $vars['tabs'] = menu_primary_local_tasks();
  $vars['tabs2'] = menu_secondary_local_tasks();

  if (arg(0) == 'user') {
    $vars['tabs'] = "";
  }

  if (arg(0) == "user" && !is_numeric(arg(1)) ) {
    $vars['template_file'] = 'page-userauth';
  }

  if ( drupal_is_front_page() && !user_is_logged_in() ) {
    $vars['template_file'] = 'page-front-anonymous';
  }  

  if (drupal_is_front_page() && user_is_logged_in() ) {
    $vars['template_file'] = 'page-h2panel';
  }


  if (arg(0) == "user" && is_numeric(arg(1)) || arg(0) == "start" ) {
    $vars['template_file'] = 'page-h2panel';
  }

  if (arg(0) == "admin" && !is_numeric(arg(1))) {
    $vars['template_file'] = 'page-bars';
  }


  // Set variables for the logo and site_name.
  if (!empty($vars['logo'])) {
    // Return the site_name even when site_name is disabled in theme settings.
    $vars['logo_alt_text'] = variable_get('site_name', '');
    $vars['site_logo'] = '<a href="'. $vars['front_page'] .'" title="'. t('Home page') .'" rel="home"><img src="'. $vars['logo'] .'" alt="'. $vars['logo_alt_text'] .' '. t('logo') .'" /></a>';
  }
  if (!empty($vars['site_name'])) {
    $vars['site_name'] = '<a href="'. $vars['front_page'] .'" title="'. t('Home page') .'" rel="home">'. $vars['site_name'] .'</a>';
  }

  // Set variables for the primary and secondary links.
  if (!empty($vars['primary_links'])) {
    $vars['primary_menu'] = theme('links', $vars['primary_links'], array('class' => 'primary-links clear-block'));
  }
  if (!empty($vars['secondary_links'])) {
    $vars['secondary_menu'] = theme('links', $vars['secondary_links'], array('class' => 'secondary-links clear-block'));
  }

  // Section class. The section class is printed on the body element and allows you to theme site sections.
  // We use the path alias otherwise all nodes will be in "section-node".
  $path_alias = drupal_get_path_alias($_GET['q']);
  if (!$vars['is_front']) {
    list($section, ) = explode('/', $path_alias, 2);
    $vars['section_class'] = 'class="'. safe_string('section-'. $section) .'"';
  }

  // Body Classes. In Genesis these are printed on the #container wrapper div, not on the body.
  $classes = explode(' ', $vars['body_classes']);

  // Remove the useless page-arg(0) class.
  if ($class = array_search(preg_replace('![^abcdefghijklmnopqrstuvwxyz0-9-]+!s', '', 'page-'. drupal_strtolower(arg(0))), $classes)) {
    unset($classes[$class]);
  }

  /**
   * Additional body classes to help out themers.
   */
  if (!$vars['is_front']) {
    $normal_path = drupal_get_normal_path($_GET['q']);
    // Set a class based on Drupals internal path, e.g. page-node-1. 
    // Using the alias is fragile because path alias's can change, $normal_path is more reliable.
    $classes[] = safe_string('page-'. $normal_path);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        $classes[] = 'page-node-add'; // Add .node-add class.
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        $classes[] = 'page-node-'. arg(2); // Add .node-edit or .node-delete classes.
      }
    }
  }
  $vars['classes'] = implode(' ', $classes); // Concatenate with spaces.

}


/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 * @param $hook
 *   The name of the theme function being called.
 */
function LCNG_preprocess_node(&$vars, $hook) {
  global $user;
  
  // Set the node id.
  $vars['node_id'] = 'node-'. $vars['node']->nid;

  // Special classes for nodes, emulate Drupal 7.
  $classes = array();
  $classes[] = 'node';
  if ($vars['promote']) {
    $classes[] = 'node-promoted';
  }
  if ($vars['sticky']) {
    $classes[] = 'node-sticky';
  }
  if (!$vars['status']) {
    $classes[] = 'node-unpublished';
  }
  if ($vars['teaser']) {
    // Node is displayed as teaser.
    $classes[] = 'node-teaser';
  }
  if (isset($vars['preview'])) {
    $classes[] = 'node-preview';
  }
  // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
  $classes[] = 'node-'. $vars['node']->type;
  $vars['classes'] = implode(' ', $classes); // Concatenate with spaces.
  
  // Modify classes for $terms to help out themers.
  $vars['terms'] = theme('links', $vars['taxonomy'], array('class' => 'links tags'));
  $vars['links'] = theme('links', $vars['node']->links, array('class' => 'links'));
  
  // Set messages if node is unpublished.
  if (!$vars['node']->status) {
    if ($vars['page']) {
      drupal_set_message(t('%title is currently unpublished', array('%title' => $vars['node']->title)), 'warning'); 
    }
    else {
      $vars['unpublished'] = '<span class="unpublished">'. t('Unpublished') .'</span>';
    }
  }
}


/**
 * Override or insert variables in comment templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 * @param $hook
 *   The name of the theme function being called.
 */
function LCNG_preprocess_comment(&$vars, $hook) {
  global $user;

  // Special classes for comments, emulate Drupal 7.
  // Load the node object that the current comment is attached to.
  $node = node_load($vars['comment']->nid);
  $classes = array();
  $classes[]  = 'comment';
  if ($vars['status'] != 'comment-published') {
    $classes[] = $vars['status'];
  }
  else {
    if ($vars['comment']->uid == 0) {
      $classes[] = 'comment-by-anonymous';
    }
    if ($vars['comment']->uid === $vars['node']->uid) {
      $classes[] = 'comment-by-node-author';
    }
    if ($vars['comment']->uid === $vars['user']->uid) {
      $classes[] = 'comment-by-viewer';
    }
    if ($vars['comment']->new) {
      $classes[] = 'comment-new';
    }
    $classes[] = $vars['zebra'];
  }
  $vars['classes'] = implode(' ', $classes);

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field', 1) == 0) {
    $vars['title'] = '';
  }

  // Set messages if comment is unpublished.
  if ($vars['comment']->status == COMMENT_NOT_PUBLISHED) {
    drupal_set_message(t('Comment #!id !title is currently unpublished', array('!id' => $vars['id'], '!title' => $vars['title'])), 'warning');
    $vars['unpublished'] = '<span class="unpublished">'. t('Unpublished') .'</span>';
 }
}


/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function LCNG_preprocess_comment_wrapper(&$vars) {
  if ($vars['content'] && $vars['node']->type != 'forum') {
    $vars['content'] = '<h2 id="comments-title">'. t('Comments') .'</h2>'.  $vars['content'];
  }
}


/**
 * Override or insert variables into block templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 * @param $hook
 *   The name of the theme function being called.
 */
function LCNG_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];
  
  // Set the block id.
  $vars['block_id'] = 'block-'. $block->module .'-'. $block->delta;

  // Special classes for blocks, emulate Drupal 7.
  // Set up variables for navigation-like blocks.
  $n1 = array('user-1', 'statistics-0');
  $n2 = array('menu', 'book', 'forum', 'blog', 'aggregator', 'comment');
  $h1 = $block->module .'-'. $block->delta;
  $h2 = $block->module;

  // Special classes for blocks
  $classes = array();
  $classes[] = 'block';
  $classes[] = 'block-'. $block->module;
  // Add nav class to navigation-like blocks.
  if (in_array($h1, $n1)) {
    $classes[] = 'nav';
  }
  if (in_array($h2, $n2)) {
    $classes[] = 'nav';
  }

  // Optionally use additional block classes
  //$classes[] = $vars['block_zebra'];        // odd, even zebra class
  //$classes[] = 'block-'. $block->region;    // block-[region] class
  //$classes[] = 'block-count-'. $vars['id']; // block-count-[count] class
  $vars['classes'] = implode(' ', $classes);
  
  /**
   * Add block edit links. Credit to the Zen theme for this implimentation. The only
   * real difference is that the Zen theme wraps each link in span, whereas Genesis 
   * outputs the links as an item-list. Also I have omitted the Views links as these 
   * seem redundant because Views has its own set of hover links.
   */
  if (user_access('administer blocks')) {
    // Display a 'Edit Block' link for blocks.
    if ($block->module == 'block') {
      $edit_links[] = l(t('Edit Block'), 'admin/build/block/configure/'. $block->module .'/'. $block->delta, 
        array(
          'attributes' => array(
            'class' => 'block-edit',
          ),
          'query' => drupal_get_destination(),
          'html' => TRUE,
        )
      );
    }
    // Display 'Configure' for other blocks.
    else {
      $edit_links[] = l(t('Configure'), 'admin/build/block/configure/'. $block->module .'/'. $block->delta,
        array(
          'attributes' => array(
            'class' => 'block-edit',
          ),
          'query' => drupal_get_destination(),
          'html' => TRUE,
        )
      );
    }
    // Display 'Edit Menu' for menu blocks.
    if (($block->module == 'menu' || ($block->module == 'user' && $block->delta == 1)) && user_access('administer menu')) {
      $menu_name = ($block->module == 'user') ? 'navigation' : $block->delta;
      $edit_links[] = l( t('Edit Menu'), 'admin/build/menu-customize/'. $menu_name, 
        array(
          'attributes' => array(
            'class' => 'block-edit',
          ),
          'query' => drupal_get_destination(),
          'html' => TRUE,
        )
      );
    }
    // Theme links as an item list.
    $vars['edit_links'] = '<div class="block-edit">'. theme('item_list', $edit_links) .'</div>';
  }
}


/**
 * Clean a string of unwanted characters.
 *
 * @param $string
 *   The string
 * @return
 *   The converted string
 */
function safe_string($string) {
$string = strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
  if (!ctype_lower($string{0})) {
    $string = 'id'. $string;
  }
  return $string;
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function LCNG_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return implode(' » ', $breadcrumb);
  }
}


/**
* Override or insert vars into user-picture.tpl.php.
* http://drupal.org/node/668362#comment-2572996
*
* Originally built by template_preprocess_user_picture() in user.module and
* imagecache_profiles_preprocess_user_picture() in imagecache_profiles.module.
*
* @see user-picture.tpl.php
*/
function LCNG_preprocess_user_picture(&$variables) {
  // Reset picture.
  $variables['picture'] = '';
  $account = $variables['account'];
  $picture = $account->picture;

  global $theme;
  $path = drupal_get_path('theme', $theme);

  // Continue only if user pictures are enabled and the imagecache_profiles module exists.
  if (variable_get('user_pictures', 0) && module_exists('imagecache_profiles')) {

    // Determine picture type.
    $picture_type = 'default';
    if (arg(0) == 'user' && is_numeric(arg(1)) && (arg(2) == NULL || arg(2) == 'edit')) {
      $picture_type = 'profile';
    }
    if (array_key_exists('cid', get_object_vars($account))) {
      $picture_type = 'comment';
    }
    if (isset($account->imagecache_preset)) {
      $picture_type = 'view';
    }

    // If the user has a picture:
    if ($account->picture && file_exists($account->picture)) {

      // Determine if we have a default ImageCache preset.
      if (variable_get('user_picture_imagecache_profiles_default', 0)) {
        // Define default user picture size.
        $size = variable_get('user_picture_imagecache_profiles_default', 0);
      }
      // If on a user profile page:
      if ($picture_type == 'profile') {
        if (variable_get('user_picture_imagecache_profiles', 0)) {
          $size = variable_get('user_picture_imagecache_profiles', 0);
        }
      }
      // If viewing a comment:
      if ($picture_type == 'comment') {
        if (variable_get('user_picture_imagecache_comments', 0)) {
          $size = variable_get('user_picture_imagecache_comments', 0);
        }
      }
      // If Views set an ImageCache preset:
      if ($picture_type == 'view') {
        $size = $account->imagecache_preset;
      }

      // Get preset.
      $preset = imagecache_preset($size);

    }
    // If user has no picture and a default picture is set:
    else if (variable_get('user_picture_default', '')) {
      $picture = variable_get('user_picture_default', '');
    }
    // Provide custom defaults. Requires user_picture_default to remain unset.
    // If user has no picture and no default picture is set:
    else {
      switch ($picture_type) {
        case 'comment' :
          $picture = $path .'/images/picture-1.png';
          break;

        case 'profile' :
        default :
          $picture = $path .'/images/picture-1.png';
          break;
      }
    }

    // Generate alt and title text.
    $alt = t("@user's picture", array('@user' => $account->name ? $account->name : variable_get('anonymous', t('Anonymous'))));

      // Generate picture.
      if (isset($preset)) {
        $variables['picture'] = theme('imagecache', $size, $picture, $alt, $alt);
      }
      else {
        $variables['picture'] = theme('image', $picture, $alt, $alt, '', FALSE);
      }

    // Link picture to account.
    /*
      if (!empty($account->uid) && user_access('access user profiles')) {
        $attributes = array('attributes' => array('title' => t('View user profile.')), 'html' => TRUE);
        $variables['picture'] = l($variables['picture'], "user/$account->uid", $attributes);
      }
    */

  }

  // Continue only if user pictures are enabled and the imagecache_profiles module does not exists.

  else if (variable_get('user_pictures', 0) ) {

    if (!$account->picture) {
        // If user has no picture and a default picture is set:
         if (variable_get('user_picture_default', '')) {
          $picture = variable_get('user_picture_default', '');
        }
        // Provide custom defaults. Requires user_picture_default to remain unset.
        // If user has no picture and no default picture is set:
        else {
          switch ($picture_type) {
            case 'comment' :
              $picture =  $path .'/images/picture-1.png';
              break;

            case 'profile' :
            default :
              $picture =  $path .'/images/picture-1.png';
              break;
          }
        }
      }
     $variables['picture'] = theme('image', $picture, $alt, $alt, '', FALSE);
  }
}


function LCNG_preprocess_user_profile(&$variables) {

  //var_dump($vars) ;
  // $vars['sample_variable'] = t('Lorem ipsum.');

  // Collect all profiles to make it easier to print all items at once.
  // $variables['user_profile'] = implode($variables['profile']);

  $variables['picture'] = drupal_render($variables['form']['picture']);

  // Profile blocks
  $variables['profile_block_about'] = theme('blocks', 'profile_block_about');
  $variables['profile_block_content'] = theme('blocks', 'profile_block_content');

  global $user;
  $variables['edit_profile_link'] = $user->uid ? l(t("Edit my profile"), "user/" . $user->uid . "/edit") : NULL;
}

/**
* Theme previous/next node
*/
function pn_node($node, $mode = 'n') {
  if (!function_exists('prev_next_nid')) {
    return NULL;
  }

  switch($mode) {
    case 'p':
      $n_nid = prev_next_nid($node->nid, 'prev');
      $link_text = 'vorherige';
      break;

    case 'n':
      $n_nid = prev_next_nid($node->nid, 'next');
      $link_text = 'nächste';
      break;

    default:
      return NULL;
  }

  if ($n_nid) {
    $n_node = node_load($n_nid);

    $options = array(
      'attributes' => array('class' => 'thumbnail'),
      'html'  => TRUE,
    );
    switch($n_node->type) {
      // For image nodes only
      case 'image':
        // This is an image node, get the thumbnail
        $html = l(image_display($n_node, 'thumbnail'), "node/$n_nid", $options);
        $html .= l($link_text, "node/$n_nid", array('html' => TRUE));
        return $html;

      // For video nodes only
      case 'video':
        foreach ($n_node->files as $fid => $file) {
          $html  = '<img src="' . base_path() . $file->filepath;
          $html .= '" alt="' . $n_node->title;
          $html .= '" title="' . $n_node->title;
          $html .= '" class="image image-thumbnail" />';
          $img_html = l($html, "node/$n_nid", $options);
          $text_html = l($link_text, "node/$n_nid", array('html' => TRUE));
          return $img_html . $text_html;
        }
      default:
        // Add other node types here if you want.
      case 'photo':
        // This is an image node, get the thumbnail
        // $html = l(image_display($n_node, 'thumbnail'), "node/$n_nid", $options);
        $html .= l($link_text, "node/$n_nid", array('html' => TRUE));
        return $html;

      case 'project':
        // This is an image node, get the thumbnail
        // $html = l(image_display($n_node, 'thumbnail'), "node/$n_nid", $options);
        $html .= l($link_text, "node/$n_nid", array('html' => TRUE));
        return $html;
    }
  }
}


function LCNG_bd_video_formatter_default($element) {
  $field = content_fields($element['#field_name'], $element['#type_name']);

  $video = _bd_video_load($element['#item']['video_id']);

  if(module_exists('bd_video_ads'))
    $video['advert'] = bd_video_ads_select_ad($field);

  _bd_video_set_render_settings($field);
  
  return _bd_video_render_video($video, 'default');
}


/**
* Implementation of hook_theme().
*/

function LCNG_theme($existing, $type, $theme, $path) {
  return array(
  'user_profile_form' => array('arguments' => array('form' => NULL),'template' => 'templates/user/user-profile-form',),
  'user_login' => array('template' => 'templates/user/user-login','arguments' => array('form' => NULL)),
  );
}

/**
* Define variables for user login, register and password templates
*/

function LCNG_preprocess_user_login(&$variables) {
  $variables['intro_text'] = t('This is my awesome login form');
  $variables['form']['name']['#size'] = 15;
  $variables['form']['pass']['#size'] = 15;
  $variables['rendered'] = drupal_render($variables['form']);
}