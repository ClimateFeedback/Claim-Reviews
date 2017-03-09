<?php
function create_claimreviews() {
    $labels = array(
        'name' => 'Claim-Reviews',
        'singular_name' => 'Claim-Review',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Claim-Review',
        'edit' => 'Edit',
        'edit_item' => 'Edit Claim-Review',
        'new_item' => 'New Claim-Review',
        'view' => 'View',
        'view_item' => 'View Claim-Review',
        'search_items' => 'Search Claim-Reviews',
        'not_found' => 'No Claim-Reviews found',
        'not_found_in_trash' => 'No Claim-Reviews found in Trash'
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
        'show_in_rest' => true,
        // then api is available at <url>/wp-json/wp/v2/claimreviews
  		  'rest_base' => 'claimreviews',
        'taxonomies' => array( 'category', 'post_tag' ),
        'supports' => array( 'title', 'thumbnail', 'excerpt', 'editor', 'revisions', 'claimreviews_admin' )
    );
    register_post_type('claimreview', $args);
}

add_action( 'init', 'create_claimreviews' );


function claimreviews_admin() {
    add_meta_box( 'claim_meta_box',
        'Claim Reviews Details',
        'display_review_meta_box',
        'claimreview', 'normal', 'high'
    );
}

add_action( 'admin_init', 'claimreviews_admin' );


function display_review_meta_box( $claim ) {

    $claimshort = esc_html( get_post_meta( $claim->ID, 'claimshort', true ) );

    $claimfull = esc_html( get_post_meta( $claim->ID, 'claimfull', true ) );

    $date = esc_html( get_post_meta( $claim->ID, 'date', true ) );

    $outlet = esc_html( get_post_meta( $claim->ID, 'outlet', true ) );

    $author = esc_html( get_post_meta( $claim->ID, 'author', true ) );

    $screenshot = esc_html( get_post_meta( $claim->ID, 'screenshot', true ) );

    $annotationsLink = esc_html( get_post_meta( $claim->ID, 'annotationsLink', true ) );

    $verdict = esc_html( get_post_meta( $claim->ID, 'verdict', true ) );

    $details = esc_html( get_post_meta( $claim->ID, 'details', true ) );

    $takeaway = esc_html( get_post_meta( $claim->ID, 'takeaway', true ) );

    ?>

    <div class="inside">
        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim short</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_short" value="<?php echo $claimshort; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim Full</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_full" value="<?php echo $claimfull; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim Date</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_date" value="<?php echo $date; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Outlet / Publisher</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_outlet" value="<?php echo $outlet; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Author</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_author" value="<?php echo $author; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Screenshot</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_screenshot" value="<?php echo $screenshot; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Link to Annotations</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_annotations" value="<?php echo $annotationsLink; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Claim verdict</p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_verdict" value="<?php echo $verdict; ?>" />
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Details</p>
            <p><em>example: <b>Inadequate backing of claim:</b> The authors did not provide a mechanism or evidence to support their claim.</em></p>
            <textarea style="width: 100%" class="claimreview-meta" rows="5" name="claim_details" id="claim_details"><?php echo $details; ?></textarea>
        </div>

        <div class="form-group">
            <p class="wpt-form-label wpt-form-textfield-label">Takeaway</p>
            <p><em></em></p>
            <input style="width: 100%" class="claimreview-meta" type="text" name="claim_takeaway" value="<?php echo $takeaway; ?>" />
        </div>
    </div>

<?php }

add_action( 'save_post', 'add_review_fields', 10, 2 );


function add_review_fields( $claim_id, $claim ) {
    if ( $claim->post_type == 'claimreview' ) {
        // Store data in post meta table if present in post data

        if ( isset( $_POST['claim_short'] ) && $_POST['claim_short'] != '' ) {
            update_post_meta( $claim_id, 'claimshort', $_POST['claim_short'] );
        }

        if ( isset( $_POST['claim_full'] ) && $_POST['claim_full'] != '' ) {
            update_post_meta( $claim_id, 'claimfull', $_POST['claim_full'] );
        }

        if ( isset( $_POST['claim_date'] ) && $_POST['claim_date'] != '' ) {
            update_post_meta( $claim_id, 'date', $_POST['claim_date'] );
        }

        if ( isset( $_POST['claim_outlet'] ) && $_POST['claim_outlet'] != '' ) {
            update_post_meta( $claim_id, 'outlet', $_POST['claim_outlet'] );
        }

        if ( isset( $_POST['claim_author'] ) && $_POST['claim_author'] != '' ) {
            update_post_meta( $claim_id, 'author', $_POST['claim_author'] );
        }

        if ( isset( $_POST['claim_screenshot'] ) && $_POST['claim_screenshot'] != '' ) {
            update_post_meta( $claim_id, 'screenshot', $_POST['claim_screenshot'] );
        }

        if ( isset( $_POST['claim_annotations'] ) && $_POST['claim_annotations'] != '' ) {
            update_post_meta( $claim_id, 'annotationsLink', $_POST['claim_annotations'] );
        }

        if ( isset( $_POST['claim_verdict'] ) && $_POST['claim_verdict'] != '' ) {
            update_post_meta( $claim_id, 'verdict', $_POST['claim_verdict'] );
        }

        if ( isset( $_POST['claim_details'] ) && $_POST['claim_details'] != '' ) {
            update_post_meta( $claim_id, 'details', $_POST['claim_details'] );
        }

        if ( isset( $_POST['claim_takeaway'] ) && $_POST['claim_takeaway'] != '' ) {
            update_post_meta( $claim_id, 'takeaway', $_POST['claim_takeaway'] );
        }
    }
}

function claimreviewsLoop( $atts ) {
    extract( shortcode_atts( array(
        'type' => 'claimreview',
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
                 <blockquote><em>"'. get_post_meta( get_the_ID(), 'claimshort', true ) .'"</em></blockquote>
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
add_shortcode('claimreviews-loop', 'claimreviewsLoop');



function claimreview_pagination( $atts ) {
    extract( shortcode_atts( array(
        'type' => 'claimreview',
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
add_shortcode('paginate-claimreview', 'claimreview_pagination');

?>
