<?php
 /**
  * Khai bao hang gia tri
  * THEME_URL = lay duong dan thu muc theme
  * CORE = lay duong dan cua thu muc /core
  */

  define('THEME_URL', get_stylesheet_directory());
  define('CORE', THEME_URL . "/core");

/**
 * Nhung file /core/init.php
 */
require_once(CORE . "/init.php");

/**
 * Thiet lap chieu rong noi dung
 */
if(!isset($content_width)) {
    $content_width = 620;
}

/**
 * Khai bao chuc nang cua theme 
 */
if(!function_exists('test_theme_setup')) {
    function test_theme_setup() {
        /**
         * Thiet lap text domain
         */
        $language_folder = THEME_URL . "/languages";
        load_theme_textdomain('trungkien', $language_folder);

        /**
         * Tu dong them link RSS len <head>
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Tu dong them thumbnail
         */
        add_theme_support('post-thumbnails');

        /**
         * Post format
         */
        add_theme_support('post-formats', array(
            'image', 'video', 'gallery', 'quote', 'link'
        ));

        /**
         * Them title-tag
         */
        add_theme_support('title-tag');

        /**
         * Theme custom background
         */
        $default_background = array (
            'default-color' => '#e8e8e8'
        );
        add_theme_support('custom-background', $default_background);
    
        /**
         * Them menu
         */
        register_nav_menu('priamry-menu', __('Primary Menu', 'trungkien'));

        /**
         * Tao sidebar
         */
        $sidebar = array(
            'name' => __('Main Sidebar', 'trungkien'),
            'id' => 'main-sidebar',
            'description' => __('Default sidebar'),
            'class' => 'main-sidebar',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        );
        register_sidebar( $sidebar );
    }
    add_action('init', 'test_theme_setup');    
}

/**
 * TEMPLATE FUNCTIONS
 */ 
if(!function_exists('test_header')) {
    function test_header() { ?>
        <div class="site-name"> 
            <?php 
                if( is_home()) {
                    printf('<h1><a href="%1$s" title="%2$s">%3$s</a></h1>', 
                        get_bloginfo('url'), 
                        get_bloginfo('description'),
                        get_bloginfo('sitename')); 
                } else {
                    printf('<p><a href="%1$s" title="%2$s">%3$s</a></p>', 
                        get_bloginfo('url'), 
                        get_bloginfo('description'),
                        get_bloginfo('sitename')); 
                }
            ?>
        </div> 
        <div class="site-description">
            <?php bloginfo('description'); ?>
        </div>
        <?php
    }
}

/**
 * Thiet lap menu
 */
if(!function_exists('test_menu')) {
    function test_menu() {
        $menu = array(
            'theme_location' => $menu,
            'container' => 'nav',
            'contanier_class' => $menu
        );
        wp_nav_menu($menu);
    }
}

/**
 * Ham tao phan trang don gian 
 */
if(!function_exists('test_pagination')) {
    function test_pagination() {
        if ($GLOBALS['wp_query'] -> max_num_pages < 2) {
            return '';
        } ?>
        <nav class="pagination" role="navigation">
            <?php if (get_next_posts_link()) : ?>
                <div class="prev"><?php next_posts_link( __('Older Posts', 'trungkien')); ?></div>
                <?php endif; ?>
            <?php if (get_previous_posts_link()) : ?>
                <div class="next"><?php previous_posts_link( __('Newest Posts', 'trungkien')); ?></div>
                <?php endif; ?>
        </nav>
        <?php
    }
}

/**
 * Ham hien thi thumbnail
 */
 if(!function_exists('test_thumbnail')) {
     function test_thumbnail($size) {
        if (!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format( 'image' )) : ?>
        <figure class="post-thumbnail"><?php the_post_thumbnail( $size ); ?></figure>
        <?php endif ?>
     <?php 
     }
 }

 /**
 * Ham hien thi tieu de post
 */
 if(!function_exists('test_entry_header')) {
     function test_entry_header() { ?>
     <?php if (is_single()) : ?>
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
        <?php else : ?>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <?php endif; ?>
     <?php
     }
 }

  /**
 * Ham lay du lieu post
 */
 if(!function_exists('test_entry_meta')) {
    function test_entry_meta() { ?>
        <?php if (!is_page()) : ?>
            <div class="entry-meta">
                <?php 
                printf( __('<span class="author">Posted by %1$s', 'trungkien'), 
                get_the_author());
                
                printf( __('<span class="date-published"> at %1$s', 'trungkien'), 
                get_the_date());

                printf( __('<span class="category"> in %1$s ', 'trungkien'), 
                get_the_category_list(','));

                if( comments_open()) :
                    echo '<span class="meta-reply">';
                    comments_popup_link(
                        __('Leave a comment', 'trungkien'),
                        __('One comment', 'trungkien'),
                        __('% comments', 'trungkien'),
                        __('Read all comments', 'trungkien')
                    );
                    echo '</span>';
                endif;
                ?>
            </div>
            <?php endif; ?>
    <?php }
}

/**
 * Ham hien thi noi dung cua post/page
 */
 if(!function_exists('test_entry_content')) {
     function test_entry_content() {
         if(!is_single()) {
             the_excerpt();
         } else {
             the_content();
             /**
              * Phan trang trong single
              */
              $link_page = array (
                  'before' => __('<p>Page: ', 'trungkien'),
                  'after' => '</p>',
                  'nextpagelink' => __('Next Page', 'trungkien'),
                  'previouspagelink' => __('Previous Page' , 'trungkien')
              );
              wp_link_pages( $link_pages );
         }
     }
 }

 function test_readmore() {
     return '<a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' .__('...[Read More]', 'trungkien'). '</a>';
 }
 add_filter( 'excerpt_more', 'test_readmore' );

 /**
  * hien thi tag
  */

  if(!function_exists('test_entry_tag')) {
      function test_entry_tag() {
          if (has_tag()) :
            echo '<div class="entry-tag">';
            printf( __('Tagged in %1$s', 'trungkien'), get_the_tag_list( '', ', '));
            echo '</div>';
          endif;
      }
  }