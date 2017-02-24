<?php
function create_articlereviews() {
    $labels = array(
        'name' => 'Article-Reviews',
        'singular_name' => 'Article-Review',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Article-Review',
        'edit' => 'Edit',
        'edit_item' => 'Edit Article-Review',
        'new_item' => 'New Article-Review',
        'view' => 'View',
        'view_item' => 'View Article-Review',
        'search_items' => 'Search Article-Reviews',
        'not_found' => 'No Article-Reviews found',
        'not_found_in_trash' => 'No Article-Reviews found in Trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 4,
        'taxonomies' => array( 'category', 'post_tag' ),
        'supports' => array( 'title', 'thumbnail', 'excerpt', 'editor', 'revisions', 'claimreviews_admin' )
    );

    register_post_type( 'articlereview', $args);
}

add_action( 'init', 'create_articlereviews' );


function articlereviews_admin() {
    add_meta_box( 'article_meta_box',
        'Article Reviews Details',
        'display_article_review_meta_box',
        'articlereview', 'normal', 'high'
    );
}

add_action( 'admin_init', 'articlereviews_admin' );


function display_article_review_meta_box( $article ) {

    $articleshort = esc_html( get_post_meta( $article->ID, 'articleshort', true ) );

    $articlefull = esc_html( get_post_meta( $article->ID, 'claimfull', true ) );

    $date = esc_html( get_post_meta( $article->ID, 'date', true ) );

    $outlet = esc_html( get_post_meta( $article->ID, 'outlet', true ) );

    $author = esc_html( get_post_meta( $article->ID, 'author', true ) );

    $screenshot = esc_html( get_post_meta( $article->ID, 'screenshot', true ) );

    $annotationsLink = esc_html( get_post_meta( $article->ID, 'annotationsLink', true ) );

    $verdict = esc_html( get_post_meta( $article->ID, 'verdict', true ) );

    $details = esc_html( get_post_meta( $article->ID, 'details', true ) );

    $takeaway = esc_html( get_post_meta( $article->ID, 'takeaway', true ) );

    ?>

    <div class="inside">
        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim short</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_short" value="<?php echo $articleshort; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim Full</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_full" value="<?php echo $articlefull; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim Date</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_date" value="<?php echo $date; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Outlet / Publisher</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_outlet" value="<?php echo $outlet; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Author</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_author" value="<?php echo $author; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Screenshot</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_screenshot" value="<?php echo $screenshot; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Link to Annotations</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_annotations" value="<?php echo $annotationsLink; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim verdict</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_verdict" value="<?php echo $verdict; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Details</p>
            <p><em>example: <b>Inadequate backing of claim:</b> The authors did not provide a mechanism or evidence to support their claim.</em></p>
            <textarea style="width: 100%" class="claimreview-meta" rows="5" name="article_details" id="article_details"><?php echo $details; ?></textarea>
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Takeaway</p>
            <p><em></em></p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="article_takeaway" value="<?php echo $takeaway; ?>" />
        </div>
    </div>

<?php }

add_action( 'save_post', 'add_article_review_fields', 10, 2 );


function add_article_review_fields( $article_id, $article ) {
    if ( $article->post_type == 'articlereview' ) {
        // Store data in post meta table if present in post data

        if ( isset( $_POST['article_short'] ) && $_POST['article_short'] != '' ) {
            update_post_meta( $article_id, 'articleshort', $_POST['article_short'] );
        }

        if ( isset( $_POST['article_full'] ) && $_POST['article_full'] != '' ) {
            update_post_meta( $article_id, 'claimfull', $_POST['article_full'] );
        }

        if ( isset( $_POST['article_date'] ) && $_POST['article_date'] != '' ) {
            update_post_meta( $article_id, 'date', $_POST['article_date'] );
        }

        if ( isset( $_POST['article_outlet'] ) && $_POST['article_outlet'] != '' ) {
            update_post_meta( $article_id, 'outlet', $_POST['article_outlet'] );
        }

        if ( isset( $_POST['article_author'] ) && $_POST['article_author'] != '' ) {
            update_post_meta( $article_id, 'author', $_POST['article_author'] );
        }

        if ( isset( $_POST['article_screenshot'] ) && $_POST['article_screenshot'] != '' ) {
            update_post_meta( $article_id, 'screenshot', $_POST['article_screenshot'] );
        }

        if ( isset( $_POST['article_annotations'] ) && $_POST['article_annotations'] != '' ) {
            update_post_meta( $article_id, 'annotationsLink', $_POST['article_annotations'] );
        }

        if ( isset( $_POST['article_verdict'] ) && $_POST['article_verdict'] != '' ) {
            update_post_meta( $article_id, 'verdict', $_POST['article_verdict'] );
        }

        if ( isset( $_POST['article_details'] ) && $_POST['article_details'] != '' ) {
            update_post_meta( $article_id, 'details', $_POST['article_details'] );
        }

        if ( isset( $_POST['article_takeaway'] ) && $_POST['article_takeaway'] != '' ) {
            update_post_meta( $article_id, 'takeaway', $_POST['article_takeaway'] );
        }
    }
}

function articlereviewsLoop( $atts ) {
    extract( shortcode_atts( array(
        'type' => 'articlereview',
    ), $atts ) );
    $output = '';
    $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
    $args = array(
        // 'post_parent' => $parent,
        'post_type' => $type,
        'sort_column'   => 'menu_order',
        'posts_per_page' => 10,
        'paged' => $paged
    );
    $yo_quiery = new WP_Query( $args );

    while ( $yo_quiery->have_posts() ) : $yo_quiery->the_post();
        $output .= '<div class="row">
        <a href="'. get_permalink( get_the_ID() ) .'"> <h3>'. get_the_title() .'</h3> </a>
            <div class="media-left">
              <a class="tagpic" href="'. get_permalink( get_the_ID() ) .'">
               <img
                src="'. get_site_url(). '/wp-content/uploads/tags/TagH_'. get_post_meta( get_the_ID(), 'verdict', true).'.png"
              >
                </a>
            </div>
            <div class="media-body">
                <p>'. get_post_meta( get_the_ID(), 'author', true ) .'<span style="font-weight:normal; font-size-adjust: 0.5;"> in</span> '. get_post_meta( get_the_ID(), 'outlet', true ) .': </p>
                 <blockquote><em>"'. get_post_meta( get_the_ID(), 'articleshort', true ) .'"</em></blockquote>
                 <p class="small">
                    <span class="square-btn">— '. get_the_date( 'd M Y' ) .'</span>
                 </p>
            </div>
        </div>
        <hr/>';
    endwhile;

    wp_reset_query();
    return $output;
}
add_shortcode('articlereviews-loop', 'articlereviewsLoop');



function articlereview_pagination( $atts ) {
    extract( shortcode_atts( array(
        'type' => 'articlereview',
    ), $atts ) );
    $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
    $args = array(
        // 'post_parent' => $parent,
        'post_type' => $type,
        'sort_column'   => 'menu_order',
        'posts_per_page' => 10,
        'paged' => $paged
    );
    $yo_quiery = new WP_Query( $args );

    $yo_quiery->query_vars['paged'] > 1 ? $current = $yo_quiery->query_vars['paged'] : $current = 1;

    $pagination = array(
        'base' => @add_query_arg('page','%#%'),
        'format' => '',
        'total' => $yo_quiery->max_num_pages,
        'current' => $current,
        'show_all' => true,
        'type' => 'list',
        'next_text' => '&raquo;',
        'prev_text' => '&laquo;'
    );

    if( !empty($yo_quiery->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );


    wp_reset_query();
    return paginate_links( $pagination );
}
add_shortcode('paginate-articlereview', 'articlereview_pagination');

?>
