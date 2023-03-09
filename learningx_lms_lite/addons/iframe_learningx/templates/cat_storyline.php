<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="iframe-menu">
        <?php
		quadmenu(array("theme_location" => "iframe-menu", "theme" => "custom_theme_3")); ?>
    </div>
    
    <div class="storyline">
    <?php
    $content_post = get_post($post->ID);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo $content;
    ?>
    </div>
<?php wp_footer(); ?>
</body>
</html>