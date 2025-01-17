<?php

	/*========================================================================================================================================================================
		Register tmls_sc Post Type
	========================================================================================================================================================================*/
	
	add_action('init', 'tmls_sc_init');
	function tmls_sc_init() 
	{
		/*----------------------------------------------------------------------
			tmls_sc Post Type Labels
		----------------------------------------------------------------------*/
		
		$labels = array(
			'name' => _x('Saved Shortcodes', 'Post type general name'),
			'singular_name' => _x('Saved Shortcodes', 'Post type singular name'),
			'add_new' => _x('Generate new shortcode', 'testimonial Item'),
			'add_new_item' => __('Generate new shortcode'),
			'edit_item' => __('Edit shortcode'),
			'new_item' => __('Generate shortcode'),
			'all_items' => __('Saved shortcodes'),
			'view_item' => __('View'),
			'search_items' => __('Search'),
			'not_found' =>  __('No shortcodes found.'),
			'not_found_in_trash' => __('No shortcodes found.'), 
			'parent_item_colon' => '',
			'menu_name' => 'Testimonials Shortcodes'
		);
		
		/*----------------------------------------------------------------------
			tmls_sc Post Type Properties
		----------------------------------------------------------------------*/
		
		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true, 
			'show_in_menu' => false, 
			'show_in_admin_bar' => false,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title')
		);
		
		/*----------------------------------------------------------------------
			Register tmls_sc Post Type Function
		----------------------------------------------------------------------*/
		
		register_post_type('tmls_sc',$args);

	}
	
	
	/*========================================================================================================================================================================
		tmls_sc Post Type All Themes Table Columns
	========================================================================================================================================================================*/
	
	/*----------------------------------------------------------------------
		tmls_sc Declaration Function
	----------------------------------------------------------------------*/
	function tmls_sc_columns($tmls_sc_columns){
		
		$tmls_sc_columns = array(

			"cb" => "<input type=\"checkbox\" />",

			"title" => "Title",
			
			"shortcode" => "Shortcode",

			"author" => "Author",
			
			"date" => "Date",

		);

		return $tmls_sc_columns;

	}
	
	/*----------------------------------------------------------------------
		tmls_sc Value Function
	----------------------------------------------------------------------*/
	function tmls_sc_columns_display($tmls_sc_columns, $post_id){
		
		global $post;
		
		if ( 'shortcode' == $tmls_sc_columns ) {
			
			echo '[tmls_saved id="'.$post_id.'"]';
		
		}
		
	}
	
	/*----------------------------------------------------------------------
		Add manage_tmls_sc_posts_columns Filter 
	----------------------------------------------------------------------*/
	add_filter("manage_tmls_sc_posts_columns", "tmls_sc_columns");
	
	/*----------------------------------------------------------------------
		Add manage_tmls_sc_posts_custom_column Action
	----------------------------------------------------------------------*/
	add_action("manage_tmls_sc_posts_custom_column",  "tmls_sc_columns_display", 10, 2 );
	
	/*========================================================================================================================================================================
		Add Meta Box For tmls_sc Post Type
	========================================================================================================================================================================*/
	
	/*----------------------------------------------------------------------
		add_meta_boxes Action For tmls_sc Post Type
	----------------------------------------------------------------------*/
	
	add_action( 'add_meta_boxes', 'tmls_sc_add_custom_box' );
	
	/*----------------------------------------------------------------------
		Properties Of tmls_sc Meta Boxes 
	----------------------------------------------------------------------*/
	
	function tmls_sc_add_custom_box() {
		add_meta_box( 
			'tmls_sc_options_metabox',
			'Options',
			'tmls_sc_options_metabox',
			'tmls_sc',
			'side'
		);
		
		add_meta_box( 
			'tmls_sc_preview_metabox',
			'Preview',
			'tmls_sc_preview_metabox',
			'tmls_sc',
			'advanced'
		);
	}
	
	/*----------------------------------------------------------------------
		Content Of tmls_sc Options Meta Box 
	----------------------------------------------------------------------*/
	
	function tmls_sc_preview_metabox( $post ) {
		?>
		<p id="noteParagraph">
			<strong>Note: </strong>Please copy and paste a shortcode in the yellow box below into page, post editor and testimonials widget. 
			<?php if ( defined( 'WPB_VC_VERSION' ) ) { echo 'Also you can use testimonials element into visual composer page builder to insert saved shortcodes.'; } ?>
		</p>
		
		<p>To change the default settings, please adjust them on the right.</p>
		<div id="tmls_div_shortcode" style="<?php if($post->post_status !='auto-draft'){ echo 'display:none;'; } ?>">[tmls]</div>
		
		<div id="tmls_div_shortcode_saved" style="<?php if($post->post_status =='auto-draft'){ echo 'display:none;'; } ?>">[tmls_saved id="<?php echo $post->ID; ?>"]</div>
		
		<input type="hidden" name="tmls_shortcode" id="tmls_shortcode" value="<?php echo get_post_meta($post->ID, 'shortcode', true); ?>" />
		
		<div id="tmls_gene_short_preview" style="display:none;">Loading ...</div>
		
		<div id="hire-us">
         
		<p style="margin-top: 30px;">This plugin is 100% free. Please do us a BIG favor and give us a 5 star rating <a href="https://wordpress.org/support/plugin/testimonials-creator/reviews/" target="_new">here</a>. If you're not happy, please <a href="mailto:hello@dictrithemes.com">get in touch with us</a>, so that we can sort it out. For more information about the plugin, please click <a href="http://www.dictrithemes.com/testimonial-creator/" target="_new">here</a>. Thank you!</p>
     
	    <p style="font-weight:bold;">Need top-notch Wordpress development work at a competitive price? Visit us at <a href="https://www.dictrithemes.com/hire-us">www.dictrithemes.com</a></p>
       
	    </div>
		<?php
	}
	
	
	/*----------------------------------------------------------------------
		Content Of tmls_sc Options Meta Box 
	----------------------------------------------------------------------*/
	
	function tmls_sc_options_metabox( $post ) {
		
		
		
		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'tmls_sc_noncename' );
		
		
			
        // category
        $category = metadata_exists('post', $post->ID, 'category_tmls') ? get_post_meta($post->ID, 'category_tmls', true) : '-1';
			
        // layout
        $layout = metadata_exists('post', $post->ID, 'layout') ? get_post_meta($post->ID, 'layout', true) : 'tmls_slider';
			
        // style
        $style = metadata_exists('post', $post->ID, 'style') ? get_post_meta($post->ID, 'style', true) : 'style1';
			
        // dialog_radius
        $dialog_radius = metadata_exists('post', $post->ID, 'dialog_radius') ? get_post_meta($post->ID, 'dialog_radius', true) : 'small_radius';
		
        // used images
        $usedimages = metadata_exists('post', $post->ID, 'usedimages') ? get_post_meta($post->ID, 'usedimages', true) : 'avatars';
        
        // image_size
        $image_size = metadata_exists('post', $post->ID, 'image_size') ? get_post_meta($post->ID, 'image_size', true) : 'large_image';
			
        // image_radius
        $image_radius = metadata_exists('post', $post->ID, 'image_radius') ? get_post_meta($post->ID, 'image_radius', true) : 'large_radius';
			
        // dialog bg color
        $dialogbgcolor = metadata_exists('post', $post->ID, 'dialogbgcolor') ? get_post_meta($post->ID, 'dialogbgcolor', true) : '#f5f5f5';
			
        // dialog border color
        $dialogbordercolor = metadata_exists('post', $post->ID, 'dialogbordercolor') ? get_post_meta($post->ID, 'dialogbordercolor', true) : '#DDDDDD';
			
        // font style
        $font_style = metadata_exists('post', $post->ID, 'font_style') ? get_post_meta($post->ID, 'font_style', true) : 'custom';
			
        // text_font_family
        $text_font_family = metadata_exists('post', $post->ID, 'text_font_family') ? get_post_meta($post->ID, 'text_font_family', true) : '';
			
        // text_font_color
        $text_font_color = metadata_exists('post', $post->ID, 'text_font_color') ? get_post_meta($post->ID, 'text_font_color', true) : '#777777';
			
        // text_font_size
        $text_font_size = metadata_exists('post', $post->ID, 'text_font_size') ? get_post_meta($post->ID, 'text_font_size', true) : '14px';
            
        // excerpt text length
        $excerpttextlength = metadata_exists('post', $post->ID, 'excerpttextlength') ? get_post_meta($post->ID, 'excerpttextlength', true) : '';
			
        // name_font_family
        $name_font_family = metadata_exists('post', $post->ID, 'name_font_family') ? get_post_meta($post->ID, 'name_font_family', true) : '';
			
        // name_font_color
        $name_font_color = metadata_exists('post', $post->ID, 'name_font_color') ? get_post_meta($post->ID, 'name_font_color', true) : '#777777';
			
        // neme_font_size
        $neme_font_size = metadata_exists('post', $post->ID, 'neme_font_size') ? get_post_meta($post->ID, 'neme_font_size', true) : '15px';
			
        // neme_font_weight
        $neme_font_weight = metadata_exists('post', $post->ID, 'neme_font_weight') ? get_post_meta($post->ID, 'neme_font_weight', true) : 'bold';
			
        // position_font_family
        $position_font_family = metadata_exists('post', $post->ID, 'position_font_family') ? get_post_meta($post->ID, 'position_font_family', true) : '';
			
        // position_font_color
        $position_font_color = metadata_exists('post', $post->ID, 'position_font_color') ? get_post_meta($post->ID, 'position_font_color', true) : '#777777';
			
        // position_font_size
        $position_font_size = metadata_exists('post', $post->ID, 'position_font_size') ? get_post_meta($post->ID, 'position_font_size', true) : '12px';
			
        // order_by
        $order_by = metadata_exists('post', $post->ID, 'order_by') ? get_post_meta($post->ID, 'order_by', true) : 'date';
			
        // order
        $order = metadata_exists('post', $post->ID, 'order') ? get_post_meta($post->ID, 'order', true) : 'DESC';
			
        // number
        $number = metadata_exists('post', $post->ID, 'number') ? get_post_meta($post->ID, 'number', true): '';
			
        // auto_play
        $auto_play = metadata_exists('post', $post->ID, 'auto_play') ? get_post_meta($post->ID, 'auto_play', true) : 'true';
			
        // transitioneffect
        $transitioneffect = metadata_exists('post', $post->ID, 'transitioneffect') ? get_post_meta($post->ID, 'transitioneffect', true) : 'crossfade';
			
        // pause_on_hover
        $pause_on_hover = metadata_exists('post', $post->ID, 'pause_on_hover') ? get_post_meta($post->ID, 'pause_on_hover', true) : 'false';
			
        // next_prev_visibility
        $next_prev_visibility = metadata_exists('post', $post->ID, 'next_prev_visibility') ? get_post_meta($post->ID, 'next_prev_visibility', true) : 'tmls_visible';
			
        // next_prev_radius
        $next_prev_radius = metadata_exists('post', $post->ID, 'next_prev_radius') ? get_post_meta($post->ID, 'next_prev_radius', true) : 'large_radius';
			
        // next_prev_position
        $next_prev_position = metadata_exists('post', $post->ID, 'next_prev_position') ? get_post_meta($post->ID, 'next_prev_position', true) : '';
			
        // next_prev_bgcolor
        $next_prev_bgcolor = metadata_exists('post', $post->ID, 'next_prev_bgcolor') ? get_post_meta($post->ID, 'next_prev_bgcolor', true) : '#F5F5F5';
			
        // next_prev_arrowscolor
        $next_prev_arrowscolor = metadata_exists('post', $post->ID, 'next_prev_arrowscolor') ? get_post_meta($post->ID, 'next_prev_arrowscolor', true) : 'tmls_lightgrayarrows';
			
        // scroll_duration
        $scroll_duration = metadata_exists('post', $post->ID, 'scroll_duration') ? get_post_meta($post->ID, 'scroll_duration', true) : '500';
			
        // pause_duration
        $pause_duration = metadata_exists('post', $post->ID, 'pause_duration') ? get_post_meta($post->ID, 'pause_duration', true) : '9000';
			
        // border_style
        $border_style = metadata_exists('post', $post->ID, 'border_style') ? get_post_meta($post->ID, 'border_style', true) : 'tmls_border tmls_dashed_border';
		  	
        // border_color
        $border_color = metadata_exists('post', $post->ID, 'border_color') ? get_post_meta($post->ID, 'border_color', true) : '#DDDDDD';
			
        // columns_number
        $columns_number = metadata_exists('post', $post->ID, 'columns_number') ? get_post_meta($post->ID, 'columns_number', true) : '2';
			
        // ratingstars
        $ratingstars = metadata_exists('post', $post->ID, 'ratingstars') ? get_post_meta($post->ID, 'ratingstars', true) : 'enabled';
			
        // ratingstarssize
        $ratingstarssize = metadata_exists('post', $post->ID, 'ratingstarssize') ? get_post_meta($post->ID, 'ratingstarssize', true) : '16px';
			
        // ratingstarscolor
        $ratingstarscolor = metadata_exists('post', $post->ID, 'ratingstarscolor') ? get_post_meta($post->ID, 'ratingstarscolor', true) : '#F47E00';
			
        // grayscale
        $grayscale = metadata_exists('post', $post->ID, 'grayscale') ? get_post_meta($post->ID, 'grayscale', true) : 'disabled';
			
        // slider2_unselectedoverlaybgcolor
        $slider2_unselectedoverlaybgcolor = metadata_exists('post', $post->ID, 'slider2_unselectedoverlaybgcolor') ? get_post_meta($post->ID, 'slider2_unselectedoverlaybgcolor', true) : '#FFFFFF';
            
        // slider2_imagesposition
        $slider2_imagesposition = metadata_exists('post', $post->ID, 'slider2_imagesposition') ? get_post_meta($post->ID, 'slider2_imagesposition', true) : 'after';
			
        // pagination
        $pagination = metadata_exists('post', $post->ID, 'pagination') ? get_post_meta($post->ID, 'pagination', true) : 'disabled';
			
        // pagination_border_style
        $pagination_border_style = metadata_exists('post', $post->ID, 'pagination_border_style') ? get_post_meta($post->ID, 'pagination_border_style', true) : 'solid';
			
        // pagination_border_color
        $pagination_border_color = metadata_exists('post', $post->ID, 'pagination_border_color') ? get_post_meta($post->ID, 'pagination_border_color', true) : '#DDDDDD';
			
        // pagination_bg_color
        $pagination_bg_color = metadata_exists('post', $post->ID, 'pagination_bg_color') ? get_post_meta($post->ID, 'pagination_bg_color', true) : 'transparent';
			
        // pagination_font_color
        $pagination_font_color = metadata_exists('post', $post->ID, 'pagination_font_color') ? get_post_meta($post->ID, 'pagination_font_color', true) : '#777777';
			
        // pagination_font_size
        $pagination_font_size = metadata_exists('post', $post->ID, 'pagination_font_size') ? get_post_meta($post->ID, 'pagination_font_size', true) : '14px';
			
        // pagination_font_family
        $pagination_font_family = metadata_exists('post', $post->ID, 'pagination_font_family') ? get_post_meta($post->ID, 'pagination_font_family', true) : '';
			
        // pagination_current_font_color
        $pagination_current_font_color = metadata_exists('post', $post->ID, 'pagination_current_font_color') ? get_post_meta($post->ID, 'pagination_current_font_color', true) : '#F47E00';
			
        // pagination_current_bg_color
        $pagination_current_bg_color = metadata_exists('post', $post->ID, 'pagination_current_bg_color') ? get_post_meta($post->ID, 'pagination_current_bg_color', true) : 'transparent';
			
        // pagination_current_border_color
        $pagination_current_border_color = metadata_exists('post', $post->ID, 'pagination_current_border_color') ? get_post_meta($post->ID, 'pagination_current_border_color', true) : '#DDDDDD';
			
        // pagination_align
        $pagination_align = metadata_exists('post', $post->ID, 'pagination_align') ? get_post_meta($post->ID, 'pagination_align', true) : 'center';
			
		// pagination_divider_style
        $pagination_divider_style = metadata_exists('post', $post->ID, 'pagination_divider_style') ? get_post_meta($post->ID, 'pagination_divider_style', true) : 'solid';
			
        // pagination_divider_color
        $pagination_divider_color = metadata_exists('post', $post->ID, 'pagination_divider_color') ? get_post_meta($post->ID, 'pagination_divider_color', true) : '#DDDDDD';
            
        // more link text
		$morelinktext = metadata_exists('post', $post->ID, 'morelinktext') ? get_post_meta($post->ID, 'morelinktext', true) : 'Read More';
            
        // more link text color
		$morelinktextcolor = metadata_exists('post', $post->ID, 'morelinktextcolor') ? get_post_meta($post->ID, 'morelinktextcolor', true) : '#F47E00';

		$tmls_wpml_current_lang ='';
		
		if(function_exists('icl_object_id')) {
			global $sitepress;
			
			if(isset($sitepress)) {
				$tmls_wpml_current_lang = $sitepress->get_current_language();
			}
		}
		
		
		?>
		<div id="tmls_gene_short_leftSidebar">
			
			<h3>Testimonial Creator</h3>
			
			<input type="hidden" id="tmls_wpml_current_lang" name="tmls_wpml_current_lang" value="<?php echo $tmls_wpml_current_lang; ?>" />
			<input type="hidden" id="tmls_id" name="tmls_id" value="<?php echo 'tmls'.$post->ID; ?>" />
			
			<div class="tmls_sectionTitle">General Settings</div>
			
			<div class="tmls_rowsContainer tmls_rowsContainerOpend" >
				<div class="row">
					<label for="tmls_category">Category Name</label>
					<?php

					wp_dropdown_categories(array('taxonomy' =>'tmlscategory',
												 'show_count' => 1, 
												 'pad_counts' => 1, 
												 'id' => 'tmls_category',
												 'name' => 'tmls_category',
												 'hide_empty' => 0,
												 'show_option_none' => 'All Categories',
												 'hierarchical'=>1,
												 'selected'=> $category));
						
					?>
				</div>
				
				<div class="row">
					<label for="tmls_orderByList">Order By</label>
					<select id="tmls_orderByList" name="tmls_orderByList">
						<option value="date" <?php if($order_by == 'date'){ echo 'selected'; } ?> >Publish Date</option>
						<option value="menu_order" <?php if($order_by == 'menu_order'){ echo 'selected'; } ?> >Order</option>
						<option value="rand" <?php if($order_by == 'rand'){ echo 'selected'; } ?> >Random </option>
					</select>
				</div>
				
				<div class="row">
					<label for="tmls_orderList">Order</label>
					<select id="tmls_orderList" name="tmls_orderList">
						<option value="DESC" <?php if($order == 'DESC'){ echo 'selected'; } ?> >Descending</option>
						<option value="ASC" <?php if($order == 'ASC'){ echo 'selected'; } ?> >Ascending</option>
					</select>
				</div>
				
			</div>
			
			
			<div class="tmls_sectionTitle">Layout</div>
			
			<div class="tmls_rowsContainer" >
				<div class="row">
					<label for="tmls_layout">Layout</label>
					<select id="tmls_layout" name="tmls_layout">
						<option value="tmls_slider" <?php if($layout == 'tmls_slider'){ echo 'selected'; } ?> >slider</option>
						<option value="tmls_slider2" <?php if($layout == 'tmls_slider2'){ echo 'selected'; } ?> >slider with thumbnails</option>
						<option value="tmls_grid" <?php if($layout == 'tmls_grid'){ echo 'selected'; } ?> >grid</option>
						<option value="tmls_list" <?php if($layout == 'tmls_list'){ echo 'selected'; } ?> >list</option>
					</select>
				</div>
				
				<div class="row grid_options list_options">
					<label for="tmls_pagination">Pagination</label>
					<select id="tmls_pagination" name="tmls_pagination">
						<option value="enabled" <?php if($pagination == 'enabled'){ echo 'selected'; } ?> >enabled</option>
						<option value="disabled" <?php if($pagination == 'disabled'){ echo 'selected'; } ?> >disabled</option>
					</select>
				</div>
				
				<div class="row">
					<label for="tmls_numberInput">Number of items <span class="pagination_option">per page</span></label>
					<input type="text" id="tmls_numberInput" name="tmls_numberInput" value="<?php echo $number; ?>" placeholder="All" />
				</div>
				
				
				<div class="row slider_options grid_options list_options">
					<label for="tmls_style">Items Style</label>
					<select id="tmls_style" name="tmls_style">
						<option value="style1" <?php if($style == 'style1'){ echo 'selected'; } ?> >style 1</option>
						<option value="style2" <?php if($style == 'style2'){ echo 'selected'; } ?> >style 2</option>
						<option value="style3" <?php if($style == 'style3'){ echo 'selected'; } ?> >style 3</option>
						<option value="style4" <?php if($style == 'style4'){ echo 'selected'; } ?> >style 4</option>
						<option value="style5" <?php if($style == 'style5'){ echo 'selected'; } ?> >style 5</option>
					</select>
				</div>
				
				<div class="row grid_options">
					<label for="tmls_columns_number">Columns Number</label>
					<select id="tmls_columns_number" name="tmls_columns_number">
						<option value="2" <?php if($columns_number == '2'){ echo 'selected'; } ?> >2 columns</option>
						<option value="3" <?php if($columns_number == '3'){ echo 'selected'; } ?> >3 columns</option>
						<option value="4" <?php if($columns_number == '4'){ echo 'selected'; } ?> >4 columns</option>
					</select>
				</div>
                
                <div class="row slider2_options">
					<label for="tmls_slider2_imagesposition">Images Position</label>
					<select id="tmls_slider2_imagesposition" name="tmls_slider2_imagesposition">
						<option value="after" <?php if($slider2_imagesposition == 'after'){ echo 'selected'; } ?> >after</option>
						<option value="befor" <?php if($slider2_imagesposition == 'befor'){ echo 'selected'; } ?> >before</option>
					</select>
				</div>
                
			</div>
			
			
			<div class="tmls_sectionTitle">Item Style</div>
			
			<div class="tmls_rowsContainer" >
				
                <div class="row">
					<label for="tmls_image_size">Images Size</label>
					<select id="tmls_image_size" name="tmls_image_size">
						<option value="xxlarge_image" <?php if($image_size == 'xxlarge_image'){ echo 'selected'; } ?> >xxlarge</option>
						<option value="xlarge_image" <?php if($image_size == 'xlarge_image'){ echo 'selected'; } ?> >xlarge</option>
						<option value="large_image" <?php if($image_size == 'large_image'){ echo 'selected'; } ?> >large</option>
						<option value="medium_image" <?php if($image_size == 'medium_image'){ echo 'selected'; } ?> >medium</option>
						<option value="small_image" <?php if($image_size == 'small_image'){ echo 'selected'; } ?> >small</option>
						<option value="no_image" <?php if($image_size == 'no_image'){ echo 'selected'; } ?> >without image</option>
					</select>
				</div>
                
                <div class="row image_options">
					<label for="tmls_usedimages">Used Images</label>
					<select id="tmls_usedimages" name="tmls_usedimages">
						<option value="avatars" <?php if($usedimages == 'avatars'){ echo 'selected'; } ?> >Avatars images</option>
                        <option value="logos" <?php if($usedimages == 'logos'){ echo 'selected'; } ?> >Logos images</option>
                        <option value="avatars_and_logos" <?php if($usedimages == 'avatars_and_logos'){ echo 'selected'; } ?> >Avatars and logos images</option>
					</select>
				</div>
				
				<div class="row image_options">
					<label for="tmls_image_radius">Avatars Images Border Radius</label>
					<select id="tmls_image_radius" name="tmls_image_radius">
						<option value="large_radius" <?php if($image_radius == 'large_radius'){ echo 'selected'; } ?> >large radius</option>
						<option value="medium_radius" <?php if($image_radius == 'medium_radius'){ echo 'selected'; } ?> >medium radius</option>
						<option value="small_radius" <?php if($image_radius == 'small_radius'){ echo 'selected'; } ?> >small radius</option>
						<option value="no_radius" <?php if($image_radius == 'no_radius'){ echo 'selected'; } ?> >without radius</option>
					</select>
				</div>
                
				<div class="row slider2_options">
					<label for="tmls_slider2_unselectedOverlayBgColor">Unselected Overlay Bg Color</label>
					<input type="text" id="tmls_slider2_unselectedOverlayBgColor" name="tmls_slider2_unselectedOverlayBgColor" value="<?php echo $slider2_unselectedoverlaybgcolor; ?>" placeholder="#FFFFFF" />
					<div id="tmls_slider2_unselectedOverlayBgColor_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_slider2_unselectedOverlayBgColor_btn" name="tmls_slider2_unselectedOverlayBgColor_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row">
					<label for="tmls_grayscale">Grayscale</label>
					<select id="tmls_grayscale" name="tmls_grayscale">
						<option value="enabled" <?php if($grayscale == 'enabled'){ echo 'selected'; } ?> >enabled</option>
						<option value="disabled" <?php if($grayscale == 'disabled'){ echo 'selected'; } ?> >disabled</option>
					</select>
				</div>
				
				<div class="row dialog_option">
					<label for="tmls_dialogRadius">Dialog Border Radius</label>
					<select id="tmls_dialogRadius" name="tmls_dialogRadius">
						<option value="large_radius" <?php if($dialog_radius == 'large_radius'){ echo 'selected'; } ?> >large radius</option>
						<option value="medium_radius" <?php if($dialog_radius == 'medium_radius'){ echo 'selected'; } ?> >medium radius</option>
						<option value="small_radius" <?php if($dialog_radius == 'small_radius'){ echo 'selected'; } ?> >small radius</option>
						<option value="no_radius" <?php if($dialog_radius == 'no_radius'){ echo 'selected'; } ?> >without radius</option>
					</select>
				</div>
				
				
				<div class="row dialog_option">
					<label for="tmls_dialogBgColor">Dialog Background Color</label>
					<input type="text" id="tmls_dialogBgColor" name="tmls_dialogBgColor" value="<?php echo $dialogbgcolor; ?>" placeholder="#F5F5F5" />
					<div id="tmls_dialogBg_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_dialogBg_color_btn" name="tmls_dialogBg_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row dialog_option">
					<label for="tmls_dialogBorderColor">Dialog Border Color</label>
					<input type="text" id="tmls_dialogBorderColor" name="tmls_dialogBorderColor" value="<?php echo $dialogbordercolor; ?>" placeholder="#DDDDDD" />
					<div id="tmls_dialogBorder_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_dialogBorder_color_btn" name="tmls_dialogBorder_color_btn" value="View Color" class="button-primary" />
				</div>
				
			</div>
			
			
			
			
			
			
			
			
			
			
			
			<div class="tmls_sectionTitle pagination_option grid_options list_options">Pagination Style</div>
			
			<div class="tmls_rowsContainer pagination_option grid_options list_options" >
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_align">Align</label>
					<select id="tmls_pagination_align" name="tmls_pagination_align">
						<option value="center" <?php if($pagination_align == 'center'){ echo 'selected'; } ?> >center</option>
						<option value="left" <?php if($pagination_align == 'left'){ echo 'selected'; } ?> >left</option>
						<option value="right" <?php if($pagination_align == 'right'){ echo 'selected'; } ?> >right</option>
					</select>
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_border_style">Border Style</label>
					<select id="tmls_pagination_border_style" name="tmls_pagination_border_style">
						<option value="solid" <?php if($pagination_border_style == 'solid'){ echo 'selected'; } ?> >solid</option>
						<option value="dashed" <?php if($pagination_border_style == 'dashed'){ echo 'selected'; } ?> >dashed</option>
						<option value="none" <?php if($pagination_border_style == 'none'){ echo 'selected'; } ?> >none</option>
					</select>
				</div>
				
				<div class="row pagination_option pagination_border_option grid_options list_options">
					<label for="tmls_pagination_border_color">Border Color</label>
					<input type="text" id="tmls_pagination_border_color" name="tmls_pagination_border_color" value="<?php echo $pagination_border_color; ?>" />
					<div id="tmls_pagination_border_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_border_color_btn" name="tmls_pagination_border_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_bg_color">Background Color</label>
					<input type="text" id="tmls_pagination_bg_color" name="tmls_pagination_bg_color" value="<?php echo $pagination_bg_color; ?>" />
					<div id="tmls_pagination_bg_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_bg_color_btn" name="tmls_pagination_bg_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_font_color">Font Color</label>
					<input type="text" id="tmls_pagination_font_color" name="tmls_pagination_font_color" value="<?php echo $pagination_font_color; ?>" />
					<div id="tmls_pagination_font_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_font_color_btn" name="tmls_pagination_font_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_font_size">Font Size (px)</label>
					<select id="tmls_pagination_font_size" name="tmls_pagination_font_size">
						<option value="9px" <?php if($pagination_font_size == '9px'){ echo 'selected'; } ?> >9</option>
						<option value="10px" <?php if($pagination_font_size == '10px'){ echo 'selected'; } ?> >10</option>
						<option value="11px" <?php if($pagination_font_size == '11px'){ echo 'selected'; } ?> >11</option>
						<option value="12px" <?php if($pagination_font_size == '12px'){ echo 'selected'; } ?> >12</option>
						<option value="13px" <?php if($pagination_font_size == '13px'){ echo 'selected'; } ?> >13</option>
						<option value="14px" <?php if($pagination_font_size == '14px'){ echo 'selected'; } ?> >14</option>
						<option value="15px" <?php if($pagination_font_size == '15px'){ echo 'selected'; } ?> >15</option>
						<option value="16px" <?php if($pagination_font_size == '16px'){ echo 'selected'; } ?> >16</option>
						<option value="17px" <?php if($pagination_font_size == '17px'){ echo 'selected'; } ?> >17</option>
						<option value="18px" <?php if($pagination_font_size == '18px'){ echo 'selected'; } ?> >18</option>
						<option value="19px" <?php if($pagination_font_size == '19px'){ echo 'selected'; } ?> >19</option>
						<option value="20px" <?php if($pagination_font_size == '20px'){ echo 'selected'; } ?> >20</option>
						<option value="21px" <?php if($pagination_font_size == '21px'){ echo 'selected'; } ?> >21</option>
						<option value="22px" <?php if($pagination_font_size == '22px'){ echo 'selected'; } ?> >22</option>
						<option value="23px" <?php if($pagination_font_size == '23px'){ echo 'selected'; } ?> >23</option>
						<option value="24px" <?php if($pagination_font_size == '24px'){ echo 'selected'; } ?> >24</option>
						<option value="25px" <?php if($pagination_font_size == '25px'){ echo 'selected'; } ?> >25</option>
						<option value="26px" <?php if($pagination_font_size == '26px'){ echo 'selected'; } ?> >26</option>
						<option value="27px" <?php if($pagination_font_size == '27px'){ echo 'selected'; } ?> >27</option>
						<option value="28px" <?php if($pagination_font_size == '28px'){ echo 'selected'; } ?> >28</option>
						<option value="29px" <?php if($pagination_font_size == '29px'){ echo 'selected'; } ?> >29</option>
						<option value="30px" <?php if($pagination_font_size == '30px'){ echo 'selected'; } ?> >30</option>
						<option value="31px" <?php if($pagination_font_size == '31px'){ echo 'selected'; } ?> >31</option>
						<option value="32px" <?php if($pagination_font_size == '32px'){ echo 'selected'; } ?> >32</option>
						<option value="33px" <?php if($pagination_font_size == '33px'){ echo 'selected'; } ?> >33</option>
						<option value="34px" <?php if($pagination_font_size == '34px'){ echo 'selected'; } ?> >34</option>
						<option value="35px" <?php if($pagination_font_size == '35px'){ echo 'selected'; } ?> >35</option>
						<option value="36px" <?php if($pagination_font_size == '36px'){ echo 'selected'; } ?> >36</option>
					</select>
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_font_family">Font Family</label>
					<select id="tmls_pagination_font_family" name="tmls_pagination_font_family">
						<option value="" <?php if($pagination_font_family == ''){ echo 'selected'; } ?> >current theme font</option>
						<option value="Georgia, serif" <?php if($pagination_font_family == 'Georgia, serif'){ echo 'selected'; } ?> >Georgia</option>
						<option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif" <?php if($pagination_font_family == "'Palatino Linotype', 'Book Antiqua', Palatino, serif"){ echo 'selected'; } ?> >Palatino Linotype</option>
						<option value="'Times New Roman', Times, serif" <?php if($pagination_font_family == "'Times New Roman', Times, serif"){ echo 'selected'; } ?> >Times New Roman</option>
						<option value="Arial, Helvetica, sans-serif" <?php if($pagination_font_family == 'Arial, Helvetica, sans-serif'){ echo 'selected'; } ?> >Arial</option>
						<option value="'Arial Black', Gadget, sans-serif" <?php if($pagination_font_family == "'Arial Black', Gadget, sans-serif"){ echo 'selected'; } ?> >Arial Black</option>
						<option value="'Comic Sans MS', cursive, sans-serif" <?php if($pagination_font_family == "'Comic Sans MS', cursive, sans-serif"){ echo 'selected'; } ?> >Comic Sans MS</option>
						<option value="Impact, Charcoal, sans-serif" <?php if($pagination_font_family == 'Impact, Charcoal, sans-serif'){ echo 'selected'; } ?> >Impact</option>
						<option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif" <?php if($pagination_font_family == "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"){ echo 'selected'; } ?> >Lucida Sans Unicode</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if($pagination_font_family == 'Tahoma, Geneva, sans-serif'){ echo 'selected'; } ?> >Tahoma</option>
						<option value="'Trebuchet MS', Helvetica, sans-serif" <?php if($pagination_font_family == "'Trebuchet MS', Helvetica, sans-serif"){ echo 'selected'; } ?> >Trebuchet MS</option>
						<option value="Verdana, Geneva, sans-serif" <?php if($pagination_font_family == 'Verdana, Geneva, sans-serif'){ echo 'selected'; } ?> >Verdana</option>
						<option value="'Courier New', Courier, monospace" <?php if($pagination_font_family == "'Courier New', Courier, monospace"){ echo 'selected'; } ?> >Courier New</option>
						<option value="'Lucida Console', Monaco, monospace" <?php if($pagination_font_family == "'Lucida Console', Monaco, monospace"){ echo 'selected'; } ?> >Lucida Console</option>
					</select>
				</div>
				
				<div class="row pagination_option pagination_border_option grid_options list_options">
					<label for="tmls_pagination_current_border_color">Current Border Color</label>
					<input type="text" id="tmls_pagination_current_border_color" name="tmls_pagination_current_border_color" value="<?php echo $pagination_current_border_color; ?>" />
					<div id="tmls_pagination_current_border_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_current_border_color_btn" name="tmls_pagination_current_border_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_current_bg_color">Current Background Color</label>
					<input type="text" id="tmls_pagination_current_bg_color" name="tmls_pagination_current_bg_color" value="<?php echo $pagination_current_bg_color; ?>" />
					<div id="tmls_pagination_current_bg_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_current_bg_color_btn" name="tmls_pagination_current_bg_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_current_font_color">Current Font Color</label>
					<input type="text" id="tmls_pagination_current_font_color" name="tmls_pagination_current_font_color" value="<?php echo $pagination_current_font_color; ?>" />
					<div id="tmls_pagination_current_font_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_current_font_color_btn" name="tmls_pagination_current_font_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row pagination_option grid_options list_options">
					<label for="tmls_pagination_divider_style">Divider Style</label>
					<select id="tmls_pagination_divider_style" name="tmls_pagination_divider_style">
						<option value="solid" <?php if($pagination_divider_style == 'solid'){ echo 'selected'; } ?> >solid</option>
						<option value="dashed" <?php if($pagination_divider_style == 'dashed'){ echo 'selected'; } ?> >dashed</option>
						<option value="none" <?php if($pagination_divider_style == 'none'){ echo 'selected'; } ?> >none</option>
					</select>
				</div>
				
				<div class="row pagination_option pagination_divider_option grid_options list_options">
					<label for="tmls_pagination_divider_color">Divider Color</label>
					<input type="text" id="tmls_pagination_divider_color" name="tmls_pagination_divider_color" value="<?php echo $pagination_divider_color; ?>" />
					<div id="tmls_pagination_divider_color_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_pagination_divider_color_btn" name="tmls_pagination_divider_color_btn" value="View Color" class="button-primary" />
				</div>
				
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
			<div class="tmls_sectionTitle">Rating Stars</div>
			
			<div class="tmls_rowsContainer" >
				<div class="row">
					<label for="tmls_ratingStars">Rating Stars</label>
					<select id="tmls_ratingStars" name="tmls_ratingStars">
						<option value="enabled" <?php if($ratingstars == 'enabled'){ echo 'selected'; } ?> >enabled</option>
						<option value="disabled" <?php if($ratingstars == 'disabled'){ echo 'selected'; } ?> >disabled</option>
					</select>
				</div>
				
				<div class="row rating_options">
					<label for="tmls_ratingStarsSize">Rating Stars Size (px)</label>
					<select id="tmls_ratingStarsSize" name="tmls_ratingStarsSize">
						<option value="9px" <?php if($ratingstarssize == '9px'){ echo 'selected'; } ?> >9</option>
						<option value="10px" <?php if($ratingstarssize == '10px'){ echo 'selected'; } ?> >10</option>
						<option value="11px" <?php if($ratingstarssize == '11px'){ echo 'selected'; } ?> >11</option>
						<option value="12px" <?php if($ratingstarssize == '12px'){ echo 'selected'; } ?> >12</option>
						<option value="13px" <?php if($ratingstarssize == '13px'){ echo 'selected'; } ?> >13</option>
						<option value="14px" <?php if($ratingstarssize == '14px'){ echo 'selected'; } ?> >14</option>
						<option value="15px" <?php if($ratingstarssize == '15px'){ echo 'selected'; } ?> >15</option>
						<option value="16px" <?php if($ratingstarssize == '16px'){ echo 'selected'; } ?> >16</option>
						<option value="17px" <?php if($ratingstarssize == '17px'){ echo 'selected'; } ?> >17</option>
						<option value="18px" <?php if($ratingstarssize == '18px'){ echo 'selected'; } ?> >18</option>
						<option value="19px" <?php if($ratingstarssize == '19px'){ echo 'selected'; } ?> >19</option>
						<option value="20px" <?php if($ratingstarssize == '20px'){ echo 'selected'; } ?> >20</option>
						<option value="21px" <?php if($ratingstarssize == '21px'){ echo 'selected'; } ?> >21</option>
						<option value="22px" <?php if($ratingstarssize == '22px'){ echo 'selected'; } ?> >22</option>
						<option value="23px" <?php if($ratingstarssize == '23px'){ echo 'selected'; } ?> >23</option>
						<option value="24px" <?php if($ratingstarssize == '24px'){ echo 'selected'; } ?> >24</option>
						<option value="25px" <?php if($ratingstarssize == '25px'){ echo 'selected'; } ?> >25</option>
						<option value="26px" <?php if($ratingstarssize == '26px'){ echo 'selected'; } ?> >26</option>
						<option value="27px" <?php if($ratingstarssize == '27px'){ echo 'selected'; } ?> >27</option>
						<option value="28px" <?php if($ratingstarssize == '28px'){ echo 'selected'; } ?> >28</option>
						<option value="29px" <?php if($ratingstarssize == '29px'){ echo 'selected'; } ?> >29</option>
						<option value="30px" <?php if($ratingstarssize == '30px'){ echo 'selected'; } ?> >30</option>
						<option value="31px" <?php if($ratingstarssize == '31px'){ echo 'selected'; } ?> >31</option>
						<option value="32px" <?php if($ratingstarssize == '32px'){ echo 'selected'; } ?> >32</option>
						<option value="33px" <?php if($ratingstarssize == '33px'){ echo 'selected'; } ?> >33</option>
						<option value="34px" <?php if($ratingstarssize == '34px'){ echo 'selected'; } ?> >34</option>
						<option value="35px" <?php if($ratingstarssize == '35px'){ echo 'selected'; } ?> >35</option>
						<option value="36px" <?php if($ratingstarssize == '36px'){ echo 'selected'; } ?> >36</option>
					</select>
				</div>
				
				<div class="row rating_options">
					<label for="tmls_ratingStarscolor">Rating Stars Color</label>
					<input type="text" id="tmls_ratingStarscolor" name="tmls_ratingStarscolor" value="<?php echo $ratingstarscolor; ?>" placeholder="#F47E00" />
					<div id="tmls_ratingStars_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_ratingStars_color_btn" name="tmls_ratingStars_color_btn" value="View Color" class="button-primary" />
				</div>
			</div>
			
			<div class="tmls_sectionTitle grid_options list_options">Dividers Style</div>
			
			<div class="tmls_rowsContainer grid_options list_options" >
				<div class="row border_options">
					<label for="tmls_border_style">Border Style</label>
					<select id="tmls_border_style" name="tmls_border_style">
						<option value="tmls_border tmls_dashed_border" <?php if($border_style == 'tmls_border tmls_dashed_border'){ echo 'selected'; } ?> >dashed</option>
						<option value="tmls_border tmls_solid_border" <?php if($border_style == 'tmls_border tmls_solid_border'){ echo 'selected'; } ?> >solid</option>
						<option value="no_border" <?php if($border_style == 'no_border'){ echo 'selected'; } ?> >without border</option>
					</select>
				</div>
				
				<div class="row border_options border_color">
					<label for="tmls_border_color">Border Color</label>
					<input type="text" id="tmls_border_color" name="tmls_border_color" class="tmls_farbtastic_input" value="<?php echo $border_color; ?>" />
					<div id="tmls_border_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_border_color_btn" name="tmls_border_color_btn" value="View Color" class="button-primary" />
				</div>
			
			</div>
			
			<div class="tmls_sectionTitle slider_options slider2_options">Slider Settings</div>
			
			<div class="tmls_rowsContainer slider_options slider2_options" >
				<div class="row slider_options slider2_options">
					<label for="tmls_auto_play">Auto Play</label>
					<select id="tmls_auto_play" name="tmls_auto_play">
						<option value="true" <?php if($auto_play == 'true'){ echo 'selected'; } ?> >true</option>
						<option value="false" <?php if($auto_play == 'false'){ echo 'selected'; } ?> >false</option>
					</select>
				</div>
				
				<div class="row slider_options slider2_options">
					<label for="tmls_transitionEffect">Transition Effect</label>
					<select id="tmls_transitionEffect" name="tmls_transitionEffect">
						<option value="crossfade" <?php if($transitioneffect == 'crossfade'){ echo 'selected'; } ?> >crossfade</option>
						<option value="scroll" <?php if($transitioneffect == 'scroll'){ echo 'selected'; } ?> >scroll</option>
					</select>
				</div>
				
				<div class="row slider_options slider2_options">
					<label for="tmls_pause_on_hover">Pause On Hover</label>
					<select id="tmls_pause_on_hover" name="tmls_pause_on_hover">
						<option value="false" <?php if($pause_on_hover == 'false'){ echo 'selected'; } ?> >false</option>
						<option value="true" <?php if($pause_on_hover == 'true'){ echo 'selected'; } ?> >true</option>
					</select>
                    <span class="tmls_note"><strong>Note:</strong> This option set automaticly to "true" if the "Excerpt Text Length" option is enabled.</span>
				</div>
				
				<div class="row slider_options">
					<label for="tmls_next_prev_visibility">Buttons Visibility</label>
					<select id="tmls_next_prev_visibility" name="tmls_next_prev_visibility">
						<option value="tmls_visible" <?php if($next_prev_visibility == 'tmls_visible'){ echo 'selected'; } ?> >visible</option>
						<option value="tmls_show_on_hover" <?php if($next_prev_visibility == 'tmls_show_on_hover'){ echo 'selected'; } ?> >show on hover</option>
						<option value="tmls_hiden" <?php if($next_prev_visibility == 'tmls_hiden'){ echo 'selected'; } ?> >hiden</option>
					</select>
				</div>
				
				<div class="row slider_options">
					<label for="tmls_next_prev_radius">Buttons Radius</label>
					<select id="tmls_next_prev_radius" name="tmls_next_prev_radius">
						<option value="large_radius" <?php if($next_prev_radius == 'large_radius'){ echo 'selected'; } ?> >large radius</option>
						<option value="medium_radius" <?php if($next_prev_radius == 'medium_radius'){ echo 'selected'; } ?> >medium radius</option>
						<option value="small_radius" <?php if($next_prev_radius == 'small_radius'){ echo 'selected'; } ?> >small radius</option>
						<option value="no_radius" <?php if($next_prev_radius == 'no_radius'){ echo 'selected'; } ?> >without radius</option>
					</select>
				</div>
				
				<div class="row slider_options">
					<label for="tmls_next_prev_position">Buttons Position</label>
					<select id="tmls_next_prev_position" name="tmls_next_prev_position">
						<option value="" <?php if($next_prev_position == ''){ echo 'selected'; } ?> >default</option>
						<option value="tmls_top" <?php if($next_prev_position == 'tmls_top'){ echo 'selected'; } ?> >top</option>
						<option value="tmls_bottom" <?php if($next_prev_position == 'tmls_bottom'){ echo 'selected'; } ?> >bottom</option>
					</select>
				</div>
				
				
				
				<div class="row slider_options">
					<label for="tmls_next_prev_bgcolor">Buttons background color</label>
					<input type="text" id="tmls_next_prev_bgcolor" name="tmls_next_prev_bgcolor" value="<?php echo $next_prev_bgcolor; ?>" />
					<div id="tmls_next_prev_bgcolor_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_next_prev_bgcolor_btn" name="tmls_next_prev_bgcolor_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row slider_options">
					<label for="tmls_next_prev_arrowscolor">Buttons arrows color</label>
					<select id="tmls_next_prev_arrowscolor" name="tmls_next_prev_arrowscolor">
						<option value="tmls_darkgrayarrows" <?php if($next_prev_arrowscolor == 'tmls_darkgrayarrows'){ echo 'selected'; } ?> >dark gray</option>
						<option value="tmls_lightgrayarrows" <?php if($next_prev_arrowscolor == 'tmls_lightgrayarrows'){ echo 'selected'; } ?>  >light gray</option>
						<option value="tmls_whitearrows" <?php if($next_prev_arrowscolor == 'tmls_whitearrows'){ echo 'selected'; } ?> >white</option>
					</select>
				</div>
				
				
				
				<div class="row slider_options slider2_options">
					<label for="tmls_scroll_duration">Scroll Duration</label>
					<input type="text" id="tmls_scroll_duration" name="tmls_scroll_duration" value="<?php echo $scroll_duration; ?>" />
				</div>
				
				<div class="row slider_options slider2_options">
					<label for="tmls_pause_duration">Pause Duration</label>
					<input type="text" id="tmls_pause_duration" name="tmls_pause_duration" value="<?php echo $pause_duration; ?>" />
				</div>
			
			</div>
			
			
			
			
			<div class="tmls_sectionTitle">Font Style</div>
			
			<div class="tmls_rowsContainer" >
				<div class="row">
					<label for="tmls_font_style">Font Style</label>
					<select id="tmls_font_style" name="tmls_font_style">
						<option value="custom" <?php if($font_style == 'custom'){ echo 'selected'; } ?> >custom style</option>
						<option value="default" <?php if($font_style == 'default'){ echo 'selected'; } ?> >current theme style</option>
					</select>
				</div>
				
				<div class="row font_options">
					<label for="tmls_text_font_family">Text Font Family</label>
					<select id="tmls_text_font_family" name="tmls_text_font_family">
						<option value="" <?php if($text_font_family == ''){ echo 'selected'; } ?> >current theme font</option>
						<option value="Georgia, serif" <?php if($text_font_family == 'Georgia, serif'){ echo 'selected'; } ?> >Georgia</option>
						<option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif" <?php if($text_font_family == "'Palatino Linotype', 'Book Antiqua', Palatino, serif"){ echo 'selected'; } ?> >Palatino Linotype</option>
						<option value="'Times New Roman', Times, serif" <?php if($text_font_family == "'Times New Roman', Times, serif"){ echo 'selected'; } ?> >Times New Roman</option>
						<option value="Arial, Helvetica, sans-serif" <?php if($text_font_family == 'Arial, Helvetica, sans-serif'){ echo 'selected'; } ?> >Arial</option>
						<option value="'Arial Black', Gadget, sans-serif" <?php if($text_font_family == "'Arial Black', Gadget, sans-serif"){ echo 'selected'; } ?> >Arial Black</option>
						<option value="'Comic Sans MS', cursive, sans-serif" <?php if($text_font_family == "'Comic Sans MS', cursive, sans-serif"){ echo 'selected'; } ?> >Comic Sans MS</option>
						<option value="Impact, Charcoal, sans-serif" <?php if($text_font_family == 'Impact, Charcoal, sans-serif'){ echo 'selected'; } ?> >Impact</option>
						<option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif" <?php if($text_font_family == "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"){ echo 'selected'; } ?> >Lucida Sans Unicode</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if($text_font_family == 'Tahoma, Geneva, sans-serif'){ echo 'selected'; } ?> >Tahoma</option>
						<option value="'Trebuchet MS', Helvetica, sans-serif" <?php if($text_font_family == "'Trebuchet MS', Helvetica, sans-serif"){ echo 'selected'; } ?> >Trebuchet MS</option>
						<option value="Verdana, Geneva, sans-serif" <?php if($text_font_family == 'Verdana, Geneva, sans-serif'){ echo 'selected'; } ?> >Verdana</option>
						<option value="'Courier New', Courier, monospace" <?php if($text_font_family == "'Courier New', Courier, monospace"){ echo 'selected'; } ?> >Courier New</option>
						<option value="'Lucida Console', Monaco, monospace" <?php if($text_font_family == "'Lucida Console', Monaco, monospace"){ echo 'selected'; } ?> >Lucida Console</option>
					</select>
				</div>
				
				<div class="row font_options">
					<label for="tmls_text_font_color">Text Font Color</label>
					<input type="text" id="tmls_text_font_color" name="tmls_text_font_color" value="<?php echo $text_font_color; ?>" placeholder="#777777" />
					<div id="tmls_text_font_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_text_font_color_btn" name="tmls_text_font_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row font_options">
					<label for="tmls_text_font_size">Text Font Size (px)</label>
					<select id="tmls_text_font_size" name="tmls_text_font_size">
						<option value="9px" <?php if($text_font_size == '9px'){ echo 'selected'; } ?> >9</option>
						<option value="10px" <?php if($text_font_size == '10px'){ echo 'selected'; } ?> >10</option>
						<option value="11px" <?php if($text_font_size == '11px'){ echo 'selected'; } ?> >11</option>
						<option value="12px" <?php if($text_font_size == '12px'){ echo 'selected'; } ?> >12</option>
						<option value="13px" <?php if($text_font_size == '13px'){ echo 'selected'; } ?> >13</option>
						<option value="14px" <?php if($text_font_size == '14px'){ echo 'selected'; } ?> >14</option>
						<option value="15px" <?php if($text_font_size == '15px'){ echo 'selected'; } ?> >15</option>
						<option value="16px" <?php if($text_font_size == '16px'){ echo 'selected'; } ?> >16</option>
						<option value="17px" <?php if($text_font_size == '17px'){ echo 'selected'; } ?> >17</option>
						<option value="18px" <?php if($text_font_size == '18px'){ echo 'selected'; } ?> >18</option>
						<option value="19px" <?php if($text_font_size == '19px'){ echo 'selected'; } ?> >19</option>
						<option value="20px" <?php if($text_font_size == '20px'){ echo 'selected'; } ?> >20</option>
						<option value="21px" <?php if($text_font_size == '21px'){ echo 'selected'; } ?> >21</option>
						<option value="22px" <?php if($text_font_size == '22px'){ echo 'selected'; } ?> >22</option>
						<option value="23px" <?php if($text_font_size == '23px'){ echo 'selected'; } ?> >23</option>
						<option value="24px" <?php if($text_font_size == '24px'){ echo 'selected'; } ?> >24</option>
						<option value="25px" <?php if($text_font_size == '25px'){ echo 'selected'; } ?> >25</option>
						<option value="26px" <?php if($text_font_size == '26px'){ echo 'selected'; } ?> >26</option>
						<option value="27px" <?php if($text_font_size == '27px'){ echo 'selected'; } ?> >27</option>
						<option value="28px" <?php if($text_font_size == '28px'){ echo 'selected'; } ?> >28</option>
						<option value="29px" <?php if($text_font_size == '29px'){ echo 'selected'; } ?> >29</option>
						<option value="30px" <?php if($text_font_size == '30px'){ echo 'selected'; } ?> >30</option>
						<option value="31px" <?php if($text_font_size == '31px'){ echo 'selected'; } ?> >31</option>
						<option value="32px" <?php if($text_font_size == '32px'){ echo 'selected'; } ?> >32</option>
						<option value="33px" <?php if($text_font_size == '33px'){ echo 'selected'; } ?> >33</option>
						<option value="34px" <?php if($text_font_size == '34px'){ echo 'selected'; } ?> >34</option>
						<option value="35px" <?php if($text_font_size == '35px'){ echo 'selected'; } ?> >35</option>
						<option value="36px" <?php if($text_font_size == '36px'){ echo 'selected'; } ?> >36</option>
					</select>
					
				</div>
				
				
				<div class="row font_options">
					<label for="tmls_name_font_family">Name Font Family</label>
					<select id="tmls_name_font_family" name="tmls_name_font_family">
						<option value="" <?php if($name_font_family == ''){ echo 'selected'; } ?> >current theme font</option>
						<option value="Georgia, serif" <?php if($name_font_family == 'Georgia, serif'){ echo 'selected'; } ?> >Georgia</option>
						<option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif" <?php if($name_font_family == "'Palatino Linotype', 'Book Antiqua', Palatino, serif"){ echo 'selected'; } ?> >Palatino Linotype</option>
						<option value="'Times New Roman', Times, serif" <?php if($name_font_family == "'Times New Roman', Times, serif"){ echo 'selected'; } ?> >Times New Roman</option>
						<option value="Arial, Helvetica, sans-serif" <?php if($name_font_family == 'Arial, Helvetica, sans-serif'){ echo 'selected'; } ?> >Arial</option>
						<option value="'Arial Black', Gadget, sans-serif" <?php if($name_font_family == "'Arial Black', Gadget, sans-serif"){ echo 'selected'; } ?> >Arial Black</option>
						<option value="'Comic Sans MS', cursive, sans-serif" <?php if($name_font_family == "'Comic Sans MS', cursive, sans-serif"){ echo 'selected'; } ?> >Comic Sans MS</option>
						<option value="Impact, Charcoal, sans-serif" <?php if($name_font_family == 'Impact, Charcoal, sans-serif'){ echo 'selected'; } ?> >Impact</option>
						<option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif" <?php if($name_font_family == "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"){ echo 'selected'; } ?> >Lucida Sans Unicode</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if($name_font_family == 'Tahoma, Geneva, sans-serif'){ echo 'selected'; } ?> >Tahoma</option>
						<option value="'Trebuchet MS', Helvetica, sans-serif" <?php if($name_font_family == "'Trebuchet MS', Helvetica, sans-serif"){ echo 'selected'; } ?> >Trebuchet MS</option>
						<option value="Verdana, Geneva, sans-serif" <?php if($name_font_family == 'Verdana, Geneva, sans-serif'){ echo 'selected'; } ?> >Verdana</option>
						<option value="'Courier New', Courier, monospace" <?php if($name_font_family == "'Courier New', Courier, monospace"){ echo 'selected'; } ?> >Courier New</option>
						<option value="'Lucida Console', Monaco, monospace" <?php if($name_font_family == "'Lucida Console', Monaco, monospace"){ echo 'selected'; } ?> >Lucida Console</option>
					</select>
				</div>
				
				
				<div class="row font_options">
					<label for="tmls_name_font_color">Name Font Color</label>
					<input type="text" id="tmls_name_font_color" name="tmls_name_font_color" value="<?php echo $name_font_color; ?>" placeholder="#777777" />
					<div id="tmls_name_font_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_name_font_color_btn" name="tmls_name_font_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row font_options">
					<label for="tmls_neme_font_size">Name Font Size (px)</label>
					<select id="tmls_neme_font_size" name="tmls_neme_font_size">
						<option value="9px" <?php if($neme_font_size == '9px'){ echo 'selected'; } ?> >9</option>
						<option value="10px" <?php if($neme_font_size == '10px'){ echo 'selected'; } ?> >10</option>
						<option value="11px" <?php if($neme_font_size == '11px'){ echo 'selected'; } ?> >11</option>
						<option value="12px" <?php if($neme_font_size == '12px'){ echo 'selected'; } ?> >12</option>
						<option value="13px" <?php if($neme_font_size == '13px'){ echo 'selected'; } ?> >13</option>
						<option value="14px" <?php if($neme_font_size == '14px'){ echo 'selected'; } ?> >14</option>
						<option value="15px" <?php if($neme_font_size == '15px'){ echo 'selected'; } ?> >15</option>
						<option value="16px" <?php if($neme_font_size == '16px'){ echo 'selected'; } ?> >16</option>
						<option value="17px" <?php if($neme_font_size == '17px'){ echo 'selected'; } ?> >17</option>
						<option value="18px" <?php if($neme_font_size == '18px'){ echo 'selected'; } ?> >18</option>
						<option value="19px" <?php if($neme_font_size == '19px'){ echo 'selected'; } ?> >19</option>
						<option value="20px" <?php if($neme_font_size == '20px'){ echo 'selected'; } ?> >20</option>
						<option value="21px" <?php if($neme_font_size == '21px'){ echo 'selected'; } ?> >21</option>
						<option value="22px" <?php if($neme_font_size == '22px'){ echo 'selected'; } ?> >22</option>
						<option value="23px" <?php if($neme_font_size == '23px'){ echo 'selected'; } ?> >23</option>
						<option value="24px" <?php if($neme_font_size == '24px'){ echo 'selected'; } ?> >24</option>
						<option value="25px" <?php if($neme_font_size == '25px'){ echo 'selected'; } ?> >25</option>
						<option value="26px" <?php if($neme_font_size == '26px'){ echo 'selected'; } ?> >26</option>
						<option value="27px" <?php if($neme_font_size == '27px'){ echo 'selected'; } ?> >27</option>
						<option value="28px" <?php if($neme_font_size == '28px'){ echo 'selected'; } ?> >28</option>
						<option value="29px" <?php if($neme_font_size == '29px'){ echo 'selected'; } ?> >29</option>
						<option value="30px" <?php if($neme_font_size == '30px'){ echo 'selected'; } ?> >30</option>
						<option value="31px" <?php if($neme_font_size == '31px'){ echo 'selected'; } ?> >31</option>
						<option value="32px" <?php if($neme_font_size == '32px'){ echo 'selected'; } ?> >32</option>
						<option value="33px" <?php if($neme_font_size == '33px'){ echo 'selected'; } ?> >33</option>
						<option value="34px" <?php if($neme_font_size == '34px'){ echo 'selected'; } ?> >34</option>
						<option value="35px" <?php if($neme_font_size == '35px'){ echo 'selected'; } ?> >35</option>
						<option value="36px" <?php if($neme_font_size == '36px'){ echo 'selected'; } ?> >36</option>
					</select>
				</div>
				
				<div class="row font_options">
					<label for="tmls_neme_font_weight">Neme Font Weight</label>
					<select id="tmls_neme_font_weight" name="tmls_neme_font_weight">
						<option value="bold" <?php if($neme_font_weight == 'bold'){ echo 'selected'; } ?> >bold</option>
						<option value="normal" <?php if($neme_font_weight == 'normal'){ echo 'selected'; } ?> >normal</option>
					</select>
				</div>
				
				
				<div class="row font_options">
					<label for="tmls_position_font_family">Position Font Family</label>
					<select id="tmls_position_font_family" name="tmls_position_font_family">
						<option value="" <?php if($position_font_family == ''){ echo 'selected'; } ?> >current theme font</option>
						<option value="Georgia, serif" <?php if($position_font_family == 'Georgia, serif'){ echo 'selected'; } ?> >Georgia</option>
						<option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif" <?php if($position_font_family == "'Palatino Linotype', 'Book Antiqua', Palatino, serif"){ echo 'selected'; } ?> >Palatino Linotype</option>
						<option value="'Times New Roman', Times, serif" <?php if($position_font_family == "'Times New Roman', Times, serif"){ echo 'selected'; } ?> >Times New Roman</option>
						<option value="Arial, Helvetica, sans-serif" <?php if($position_font_family == 'Arial, Helvetica, sans-serif'){ echo 'selected'; } ?> >Arial</option>
						<option value="'Arial Black', Gadget, sans-serif" <?php if($position_font_family == "'Arial Black', Gadget, sans-serif"){ echo 'selected'; } ?> >Arial Black</option>
						<option value="'Comic Sans MS', cursive, sans-serif" <?php if($position_font_family == "'Comic Sans MS', cursive, sans-serif"){ echo 'selected'; } ?> >Comic Sans MS</option>
						<option value="Impact, Charcoal, sans-serif" <?php if($position_font_family == 'Impact, Charcoal, sans-serif'){ echo 'selected'; } ?> >Impact</option>
						<option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif" <?php if($position_font_family == "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"){ echo 'selected'; } ?> >Lucida Sans Unicode</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if($position_font_family == 'Tahoma, Geneva, sans-serif'){ echo 'selected'; } ?> >Tahoma</option>
						<option value="'Trebuchet MS', Helvetica, sans-serif" <?php if($position_font_family == "'Trebuchet MS', Helvetica, sans-serif"){ echo 'selected'; } ?> >Trebuchet MS</option>
						<option value="Verdana, Geneva, sans-serif" <?php if($position_font_family == 'Verdana, Geneva, sans-serif'){ echo 'selected'; } ?> >Verdana</option>
						<option value="'Courier New', Courier, monospace" <?php if($position_font_family == "'Courier New', Courier, monospace"){ echo 'selected'; } ?> >Courier New</option>
						<option value="'Lucida Console', Monaco, monospace" <?php if($position_font_family == "'Lucida Console', Monaco, monospace"){ echo 'selected'; } ?> >Lucida Console</option>
					</select>
				</div>
				
				
				<div class="row font_options">
					<label for="tmls_position_font_color">Position Font Color</label>
					<input type="text" id="tmls_position_font_color" name="tmls_position_font_color" value="<?php echo $position_font_color; ?>" placeholder="#777777" />
					<div id="tmls_position_font_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_position_font_color_btn" name="tmls_position_font_color_btn" value="View Color" class="button-primary" />
				</div>
				
				<div class="row font_options">
					<label for="tmls_position_font_size">Position Font Size (px)</label>
					<select id="tmls_position_font_size" name="tmls_position_font_size">
						<option value="9px" <?php if($position_font_size == '9px'){ echo 'selected'; } ?> >9</option>
						<option value="10px" <?php if($position_font_size == '10px'){ echo 'selected'; } ?> >10</option>
						<option value="11px" <?php if($position_font_size == '11px'){ echo 'selected'; } ?> >11</option>
						<option value="12px" <?php if($position_font_size == '12px'){ echo 'selected'; } ?> >12</option>
						<option value="13px" <?php if($position_font_size == '13px'){ echo 'selected'; } ?> >13</option>
						<option value="14px" <?php if($position_font_size == '14px'){ echo 'selected'; } ?> >14</option>
						<option value="15px" <?php if($position_font_size == '15px'){ echo 'selected'; } ?> >15</option>
						<option value="16px" <?php if($position_font_size == '16px'){ echo 'selected'; } ?> >16</option>
						<option value="17px" <?php if($position_font_size == '17px'){ echo 'selected'; } ?> >17</option>
						<option value="18px" <?php if($position_font_size == '18px'){ echo 'selected'; } ?> >18</option>
						<option value="19px" <?php if($position_font_size == '19px'){ echo 'selected'; } ?> >19</option>
						<option value="20px" <?php if($position_font_size == '20px'){ echo 'selected'; } ?> >20</option>
						<option value="21px" <?php if($position_font_size == '21px'){ echo 'selected'; } ?> >21</option>
						<option value="22px" <?php if($position_font_size == '22px'){ echo 'selected'; } ?> >22</option>
						<option value="23px" <?php if($position_font_size == '23px'){ echo 'selected'; } ?> >23</option>
						<option value="24px" <?php if($position_font_size == '24px'){ echo 'selected'; } ?> >24</option>
						<option value="25px" <?php if($position_font_size == '25px'){ echo 'selected'; } ?> >25</option>
						<option value="26px" <?php if($position_font_size == '26px'){ echo 'selected'; } ?> >26</option>
						<option value="27px" <?php if($position_font_size == '27px'){ echo 'selected'; } ?> >27</option>
						<option value="28px" <?php if($position_font_size == '28px'){ echo 'selected'; } ?> >28</option>
						<option value="29px" <?php if($position_font_size == '29px'){ echo 'selected'; } ?> >29</option>
						<option value="30px" <?php if($position_font_size == '30px'){ echo 'selected'; } ?> >30</option>
						<option value="31px" <?php if($position_font_size == '31px'){ echo 'selected'; } ?> >31</option>
						<option value="32px" <?php if($position_font_size == '32px'){ echo 'selected'; } ?> >32</option>
						<option value="33px" <?php if($position_font_size == '33px'){ echo 'selected'; } ?> >33</option>
						<option value="34px" <?php if($position_font_size == '34px'){ echo 'selected'; } ?> >34</option>
						<option value="35px" <?php if($position_font_size == '35px'){ echo 'selected'; } ?> >35</option>
						<option value="36px" <?php if($position_font_size == '36px'){ echo 'selected'; } ?> >36</option>
					</select>
				</div>
			
			
			</div>
			
			
			<div class="tmls_sectionTitle">Excerpt Text Settings</div>
			
			<div class="tmls_rowsContainer" >
                <div class="row">
					<label for="tmls_excerpttextlength">Excerpt Text Length</label>
					<input type="text" id="tmls_excerpttextlength" name="tmls_excerpttextlength" value="<?php echo $excerpttextlength; ?>" placeholder="All text" />
				</div>
                
				<div class="row">
					<label for="tmls_morelinktext">More Link Text</label>
					<input type="text" id="tmls_morelinktext" name="tmls_morelinktext" value="<?php echo $morelinktext; ?>" />
				</div>
				
				<div class="row">
					<label for="tmls_morelinktextcolor">More Link Text Color</label>
					<input type="text" id="tmls_morelinktextcolor" name="tmls_morelinktextcolor" value="<?php echo $morelinktextcolor; ?>" placeholder="<?php echo $morelinktextcolor; ?>" />
					<div id="tmls_morelinktextcolor_colorpicker" class="tmls_farbtastic"></div>
					<input type="button" id="tmls_morelinktextcolor_btn" name="tmls_morelinktextcolor_btn" value="View Color" class="button-primary" />
				</div>
			</div>
			
		</div>
		<?php
	}
	
	/*========================================================================================================================================================================
		Save tmls_sc Options Meta Box Function
	========================================================================================================================================================================*/
	
	function tmls_sc_save_meta_box($post_id) 
	{
		/*----------------------------------------------------------------------
			shortcode
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_shortcode'])) {
			update_post_meta($post_id, 'shortcode', $_POST['tmls_shortcode']);
		}
		
		/*----------------------------------------------------------------------
			category
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_category'])) {
			update_post_meta($post_id, 'category_tmls', $_POST['tmls_category']);
		}
		
		/*----------------------------------------------------------------------
			layout
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_layout'])) {
			update_post_meta($post_id, 'layout', $_POST['tmls_layout']);
		}
		
		/*----------------------------------------------------------------------
			style
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_style'])) {
			update_post_meta($post_id, 'style', $_POST['tmls_style']);
		}
            
        /*----------------------------------------------------------------------
            used images
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_usedimages'])) {
			update_post_meta($post_id, 'usedimages', $_POST['tmls_usedimages']);
		}
        
		/*----------------------------------------------------------------------
			image size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_image_size'])) {
			update_post_meta($post_id, 'image_size', $_POST['tmls_image_size']);
		}
		
		/*----------------------------------------------------------------------
			image radius
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_image_radius'])) {
			update_post_meta($post_id, 'image_radius', $_POST['tmls_image_radius']);
		}
		
		/*----------------------------------------------------------------------
			dialog radius
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_dialogRadius'])) {
			update_post_meta($post_id, 'dialog_radius', $_POST['tmls_dialogRadius']);
		}
		
		/*----------------------------------------------------------------------
			dialog bg color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_dialogBgColor'])) {
			update_post_meta($post_id, 'dialogbgcolor', $_POST['tmls_dialogBgColor']);
		}
		
		/*----------------------------------------------------------------------
			dialog border color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_dialogBorderColor'])) {
			update_post_meta($post_id, 'dialogbordercolor', $_POST['tmls_dialogBorderColor']);
		}
		 
		/*----------------------------------------------------------------------
			font style
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_font_style'])) {
			update_post_meta($post_id, 'font_style', $_POST['tmls_font_style']);
		}
		
		/*----------------------------------------------------------------------
			text font family
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_text_font_family'])) {
			update_post_meta($post_id, 'text_font_family', $_POST['tmls_text_font_family']);
		}
		
		/*----------------------------------------------------------------------
			text font color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_text_font_color'])) {
			update_post_meta($post_id, 'text_font_color', $_POST['tmls_text_font_color']);
		}
		
		/*----------------------------------------------------------------------
			text font size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_text_font_size'])) {
			update_post_meta($post_id, 'text_font_size', $_POST['tmls_text_font_size']);
		}
        
        /*----------------------------------------------------------------------
			excerpt text length
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_excerpttextlength'])) {
			update_post_meta($post_id, 'excerpttextlength', $_POST['tmls_excerpttextlength']);
		}
        
		/*----------------------------------------------------------------------
			name font family
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_name_font_family'])) {
			update_post_meta($post_id, 'name_font_family', $_POST['tmls_name_font_family']);
		}
		
		/*----------------------------------------------------------------------
			name font color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_name_font_color'])) {
			update_post_meta($post_id, 'name_font_color', $_POST['tmls_name_font_color']);
		}
		
		/*----------------------------------------------------------------------
			neme font size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_neme_font_size'])) {
			update_post_meta($post_id, 'neme_font_size', $_POST['tmls_neme_font_size']);
		}
		
		/*----------------------------------------------------------------------
			neme font weight
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_neme_font_weight'])) {
			update_post_meta($post_id, 'neme_font_weight', $_POST['tmls_neme_font_weight']);
		}
		
		/*----------------------------------------------------------------------
			position font family
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_position_font_family'])) {
			update_post_meta($post_id, 'position_font_family', $_POST['tmls_position_font_family']);
		}
		
		/*----------------------------------------------------------------------
			position font color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_position_font_color'])) {
			update_post_meta($post_id, 'position_font_color', $_POST['tmls_position_font_color']);
		}
		
		/*----------------------------------------------------------------------
			position font size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_position_font_size'])) {
			update_post_meta($post_id, 'position_font_size', $_POST['tmls_position_font_size']);
		}
		
		/*----------------------------------------------------------------------
			order by
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_orderByList'])) {
			update_post_meta($post_id, 'order_by', $_POST['tmls_orderByList']);
		}
		
		/*----------------------------------------------------------------------
			order
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_orderList'])) {
			update_post_meta($post_id, 'order', $_POST['tmls_orderList']);
		}
		
		/*----------------------------------------------------------------------
			number
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_numberInput'])) {
			update_post_meta($post_id, 'number', $_POST['tmls_numberInput']);
		}
		
		/*----------------------------------------------------------------------
			auto play
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_auto_play'])) {
			update_post_meta($post_id, 'auto_play', $_POST['tmls_auto_play']);
		}
		
		/*----------------------------------------------------------------------
			transition effect
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_transitionEffect'])) {
			update_post_meta($post_id, 'transitioneffect', $_POST['tmls_transitionEffect']);
		}
		
		/*----------------------------------------------------------------------
			pause on hover
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pause_on_hover'])) {
			update_post_meta($post_id, 'pause_on_hover', $_POST['tmls_pause_on_hover']);
		}
		
		/*----------------------------------------------------------------------
			next prev visibility
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_next_prev_visibility'])) {
			update_post_meta($post_id, 'next_prev_visibility', $_POST['tmls_next_prev_visibility']);
		}
		
		/*----------------------------------------------------------------------
			next prev radius
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_next_prev_radius'])) {
			update_post_meta($post_id, 'next_prev_radius', $_POST['tmls_next_prev_radius']);
		}
		
		/*----------------------------------------------------------------------
			next prev position
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_next_prev_position'])) {
			update_post_meta($post_id, 'next_prev_position', $_POST['tmls_next_prev_position']);
		}
		
		/*----------------------------------------------------------------------
			next prev bgcolor
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_next_prev_bgcolor'])) {
			update_post_meta($post_id, 'next_prev_bgcolor', $_POST['tmls_next_prev_bgcolor']);
		}
		
		/*----------------------------------------------------------------------
			next prev arrows color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_next_prev_arrowscolor'])) {
			update_post_meta($post_id, 'next_prev_arrowscolor', $_POST['tmls_next_prev_arrowscolor']);
		}
		
		/*----------------------------------------------------------------------
			scroll duration
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_scroll_duration'])) {
			update_post_meta($post_id, 'scroll_duration', $_POST['tmls_scroll_duration']);
		}
		
		/*----------------------------------------------------------------------
			pause duration
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pause_duration'])) {
			update_post_meta($post_id, 'pause_duration', $_POST['tmls_pause_duration']);
		}
		
		/*----------------------------------------------------------------------
			border style
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_border_style'])) {
			update_post_meta($post_id, 'border_style', $_POST['tmls_border_style']);
		}
		
		/*----------------------------------------------------------------------
			border color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_border_color'])) {
			update_post_meta($post_id, 'border_color', $_POST['tmls_border_color']);
		}
		
		/*----------------------------------------------------------------------
			columns number
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_columns_number'])) {
			update_post_meta($post_id, 'columns_number', $_POST['tmls_columns_number']);
		}
		
		/*----------------------------------------------------------------------
			rating stars
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_ratingStars'])) {
			update_post_meta($post_id, 'ratingstars', $_POST['tmls_ratingStars']);
		}
		
		/*----------------------------------------------------------------------
			rating stars size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_ratingStarsSize'])) {
			update_post_meta($post_id, 'ratingstarssize', $_POST['tmls_ratingStarsSize']);
		}
		
		/*----------------------------------------------------------------------
			rating stars color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_ratingStarscolor'])) {
			update_post_meta($post_id, 'ratingstarscolor', $_POST['tmls_ratingStarscolor']);
		}
		
		/*----------------------------------------------------------------------
			grayscale
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_grayscale'])) {
			update_post_meta($post_id, 'grayscale', $_POST['tmls_grayscale']);
		}
		
		/*----------------------------------------------------------------------
			slider2 unselected overlay bg color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_slider2_unselectedOverlayBgColor'])) {
			update_post_meta($post_id, 'slider2_unselectedoverlaybgcolor', $_POST['tmls_slider2_unselectedOverlayBgColor']);
		}
        
        /*----------------------------------------------------------------------
			slider2 images position
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_slider2_imagesposition'])) {
			update_post_meta($post_id, 'slider2_imagesposition', $_POST['tmls_slider2_imagesposition']);
		}
		
		/*----------------------------------------------------------------------
			pagination
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination'])) {
			update_post_meta($post_id, 'pagination', $_POST['tmls_pagination']);
		}
		
		/*----------------------------------------------------------------------
			pagination_border_style
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_border_style'])) {
			update_post_meta($post_id, 'pagination_border_style', $_POST['tmls_pagination_border_style']);
		}
		
		/*----------------------------------------------------------------------
			pagination_border_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_border_color'])) {
			update_post_meta($post_id, 'pagination_border_color', $_POST['tmls_pagination_border_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_bg_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_bg_color'])) {
			update_post_meta($post_id, 'pagination_bg_color', $_POST['tmls_pagination_bg_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_font_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_font_color'])) {
			update_post_meta($post_id, 'pagination_font_color', $_POST['tmls_pagination_font_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_font_size
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_font_size'])) {
			update_post_meta($post_id, 'pagination_font_size', $_POST['tmls_pagination_font_size']);
		}
		
		/*----------------------------------------------------------------------
			pagination_font_family
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_font_family'])) {
			update_post_meta($post_id, 'pagination_font_family', $_POST['tmls_pagination_font_family']);
		}
		
		/*----------------------------------------------------------------------
			pagination_current_font_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_current_font_color'])) {
			update_post_meta($post_id, 'pagination_current_font_color', $_POST['tmls_pagination_current_font_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_current_bg_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_current_bg_color'])) {
			update_post_meta($post_id, 'pagination_current_bg_color', $_POST['tmls_pagination_current_bg_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_current_border_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_current_border_color'])) {
			update_post_meta($post_id, 'pagination_current_border_color', $_POST['tmls_pagination_current_border_color']);
		}
		
		/*----------------------------------------------------------------------
			pagination_align
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_align'])) {
			update_post_meta($post_id, 'pagination_align', $_POST['tmls_pagination_align']);
		}
		
		/*----------------------------------------------------------------------
			pagination_divider_style
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_divider_style'])) {
			update_post_meta($post_id, 'pagination_divider_style', $_POST['tmls_pagination_divider_style']);
		}
		
		/*----------------------------------------------------------------------
			pagination_divider_color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_pagination_divider_color'])) {
			update_post_meta($post_id, 'pagination_divider_color', $_POST['tmls_pagination_divider_color']);
		}
        
        /*----------------------------------------------------------------------
			more link text
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_morelinktext'])) {
			update_post_meta($post_id, 'morelinktext', $_POST['tmls_morelinktext']);
		}
        
        /*----------------------------------------------------------------------
			more link text color
		----------------------------------------------------------------------*/
		if(isset($_POST['tmls_morelinktextcolor'])) {
			update_post_meta($post_id, 'morelinktextcolor', $_POST['tmls_morelinktextcolor']);
		}
		
	}
	
	/*----------------------------------------------------------------------
		Save tmls_sc Options Meta Box Action
	----------------------------------------------------------------------*/
	add_action('save_post', 'tmls_sc_save_meta_box');

?>