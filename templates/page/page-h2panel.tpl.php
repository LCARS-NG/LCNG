<?php
// $Id: page-h2panel.tpl.php 126 2011-11-05 19:45:14Z giang $

/**
 * @file page.tpl.php
 * Theme implementation to display a single Drupal page for Genesis Subtheme.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *     least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *     themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *     so on).
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *     for the page.
 * - $section_class: A CSS class that uses .section + the 1st URL argument, allows for
 *     themeing site sections based on path.
 * - $classes: A set of CSS classes (preprocess $body_classes + Genesis custom classes).
 *     This contains flags indicating the current layout (multiple columns, single column),
 *     the current path, whether the user is logged in, and so on.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *     when linking to the front page. This includes the language domain or prefix.
 * - $site_logo: The preprocessed $logo varaible. Includes the path to the logo image,
 *     as defined in theme configuration and wrapped in an anchor linking to the homepage.
 * - $site_name: The name of the site (preprocessed) wrapped in an anchor linking to the homepage.
 *     Empty when display has been disabled in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *     in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *     in theme settings.
 *
 * Navigation:
 * - $primary_menu: The preprocessed $primary_links (array), an array containing primary
 *     navigation links for the site, if they have been configured.
 * - $secondary_menu: The preprocessed $secondary_links (array), an array containing secondary
 *     navigation links for the site, if they have been configured.
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 *
 * Page content (in order of occurrance in the default page.tpl.php):
 * - $leaderboard: Custom region for displaying content at the top of the page, useful
 *     for displaying a banner.
 * - $header: The header blocks region for display content in the header.
 * - $secondary_content: Full width custom region for displaying content between the header
 *     and the main content columns.
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $content_top: A custom region for displaying content above the main content.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *     and edit tabs when displaying a node).
 * - $content: The main content of the current Drupal page.
 * - $content_bottom: A custom region for displaying content above the main content.
 * - $left: Region for the left sidebar.
 * - $right: Region for the right sidebar.
 * - $tertiary_content: Full width custom region for displaying content between main content
 *   columns and the footer.
 *
 * Footer/closing data:
 * - $footer : The footer region.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $closure: Final closing markup from any modules that have altered the page.
 *     This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see genesis_preprocess_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<?php
/**
 * Change the body id selector to your preferred layout, e.g body id="genesis-1a".
 * @see layout.css
 */
?>
<body id="genesis-1c" class="h2panel">
  <div id="container" class="<?php print $classes; ?>">

    <!--//   start header   //-->
    <div id="header" class="clear-block">

    <!--//   start content columns  //-->
    <div id="columns">
      <div class="columns-inner clear-block">
        <div id="content-column">

          <?php if ($site_logo || $site_name || $site_slogan): ?>
            <div id="branding">

              <?php if ($site_logo or $site_name): ?>
                <h1 class="logo-site-name">
                  <?php if ($site_logo): ?><span id="logo"><?php print $site_logo; ?></span><?php endif; ?>
                  <?php if ($site_name): ?><span id="site-name"><?php print $site_name; ?></span><?php endif; ?>
                </h1>
              <?php endif; ?>

              <?php if ($site_slogan): ?><div id="site-slogan"><?php print $site_slogan; ?></div><?php endif; ?>
            </div> <!-- /branding -->
          <?php endif; ?>
          
          <div class="content-inner top-panel">

          <!--//   Four column Gpanel   //-->

            <div class="four-col-25 gpanel clear-block">
              <div class="section-1">
                <div class="section region col-1 first">
                  <div class="inner">
                    <?php if ($four_col_first): print $four_col_first; endif; ?>
                  </div>
                </div>
                <div class="section region col-2">
                  <div class="inner">
                    <?php if ($four_col_second): print $four_col_second; endif; ?>
                  </div>
                </div>
              </div>
              <div class="section-2">
                <div class="section region col-3">
                  <div class="inner">
                    <?php if ($four_col_third): print $four_col_third; endif; ?>
                  </div>
                </div>
                <div class="section region col-4 last">
                  <div class="inner">
                    <?php if ($four_col_fourth): print $four_col_fourth; endif; ?>
                  </div>
                </div>
              </div>
            </div>

          <!--/end Gpanel-->

        </div> <!-- /content-inner -->
      </div> <!-- /content-column -->

        <div id="sidebar-menus" class="section sidebar region">
          <div class="sidebar-inner">
            <?php if ($sidebar_topmenus): ?><?php print $sidebar_topmenus; ?><?php endif; ?>
          </div>
        </div> <!-- /sidebar-menus -->
        
        <div class="sidebar-bg">&nbsp;</div>

      </div> <!-- /columns-inner -->

    </div> <!-- /columns -->
    <!--//   end content columns  //-->

      <!--//   start bottom mainframe   //-->
      <div class="lbow-bottomleft-positiv">
        <div class="lbow-bottomleft-negativ">
          <div class="lbow-content">
            <?php if ($h2panel_status): print $h2panel_status; endif; ?>
            <?php
              // $datetime = date_now(); //$now = format_date(time(), 'custom','Y-m-d', 0);
              // $date_object = date_make_date($datetime); echo $formatted_date = date_format_date($date_object,'short'). '_';
              // $block = module_invoke('clock', 'block', 'view','clock'); print $block['content'];
              // print theme('jstimer', 'jst_clock', array('clock_type' => 1 ));
            ?>
          </div>
        </div> <!-- /lbow-bottomleft-negativ -->
        <div class="lbow-bottomleft-bar"></div>  <!-- /lbow-bottomleft-positiv -->
      </div> <!-- /lbow-bottomleft-positiv -->
      <!--//   /end bottom mainframe   //-->

      <!--//   start top mainframe   //-->
      <div class="lbow-topleft-positiv">
        <div class="lbow-topleft-bar"></div>
        <div class="lbow-topleft-negativ">
          <div class="lbow-content">
          
            <?php if ($breadcrumb): ?>
              <div id="breadcrumb" class="nav">
                <?php print $breadcrumb; ?>
              </div>
            <?php endif; ?>
            
          </div><!-- /lbow-topleft-content -->
        </div><!-- /insideframe -->
      </div><!-- /mainframe -->
      <!--//   end top mainframe   //-->

    </div> <!-- /header -->

    <!--//   start content columns  //-->
    <div id="columns">
      <div class="columns-inner clear-block">
        <div id="content-column">
          <div class="content-inner">
          <!--
            <?php if ($primary_menu or $secondary_menu): ?>

              <div id="nav" class="clear-block">
                <?php if ($primary_menu): ?><div id="primary"><?php print $primary_menu; ?></div><?php endif; ?>
                <?php if ($secondary_menu): ?><div id="secondary"><?php print $secondary_menu; ?></div><?php endif; ?>
              </div>
            <?php endif; ?>
            /nav -->

            <?php if ($leaderboard): ?>
              <div id="leaderboard" class="section region"><div class="region-inner">
                <?php print $leaderboard; ?>
              </div></div> <!-- /leaderboard -->
            <?php endif; ?>

            <?php if ($header): ?>
              <div id="header-blocks" class="section region"><div class="region-inner">
                <?php print $header; ?>
              </div></div> <!-- /header-blocks -->
            <?php endif; ?>

            <?php if ($secondary_content): ?>
              <div id="secondary-content" class="section region"><div class="region-inner">
                <?php print $secondary_content; ?>
              </div></div> <!-- /secondary-content -->
            <?php endif; ?>

        <?php if ($content_top): ?>
          <div id="content-top" class="section region"><?php print $content_top; ?></div> <!-- /content-top -->
        <?php endif; ?>

        <div id="main-content">
          <?php if ($title): ?>
              <div id="page-title">
                <h2><?php print $title; ?></h2>
              </div>
            <?php endif; ?>
          <?php if ($messages): print $messages; endif; ?>
          <?php if ($help): print $help; endif; ?>
          <div id="content" class="section region">
            <?php print $content; ?>
          </div>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($tabs): ?><div class="local-tasks"><div class="clear-block"><?php print $tabs; ?></div></div><?php endif; ?>
          <?php if ($tertiary_content): ?><div id="tertiary-content" class="section region clear-block"><div class="region-inner"><?php print $tertiary_content; ?></div></div> <!-- /tertiary-content --><?php endif; ?>
          </div> <!-- /main-content -->
          <?php if ($search_box): ?><div id="search-box"><?php print $search_box; ?></div><?php endif; ?>
        <?php if ($content_bottom): ?>
          <div id="content-bottom" class="section region"><?php print $content_bottom; ?></div> <!-- /content-bottom -->
        <?php endif; ?>

      </div></div> <!-- /content-column -->

        <div id="sidebar-menus" class="section sidebar region" >
          <div id="sidebar-magicheight" >
            <div class="sidebar-inner">
              <?php if ($sidebar_menus): ?>
                  <?php print $sidebar_menus; ?>
              <?php endif; ?>
              
              <?php if ($left): ?>
                  <?php print $left; ?>
              <?php endif; ?>
            </div>
          </div> <!-- /sidebar-eqheight -->
        </div> <!-- /sidebar-menus -->

      <?php if ($right): ?>
        <div id="sidebar-right" class="section sidebar region">
          <div class="sidebar-inner">
            <?php print $right; ?>
          </div>
        </div> <!-- /sidebar-right -->
      <?php endif; ?>

      </div> <!-- /columns-inner -->

      <div id="foot-wrapper" class="clear-block">

        <?php if ($footer): ?>
          <div id="footer" class="section region">

        <?php if ($footer_message or $feed_icons): ?>
          <div id="footer-message"><?php print $footer_message; ?><?php print $feed_icons; ?></div> <!-- /footer-message/feed-icon -->
        <?php endif; ?>

          <div class="region-inner">
        <?php print $footer; ?>
          </div></div> <!-- /footer -->
        <?php endif; ?>

      </div> <!-- /footer-wraper -->
    </div> <!-- /columns -->
    <!--//   end content columns  //-->
  </div> <!-- /container -->
  <?php print $closure; ?>
</body>
</html>
