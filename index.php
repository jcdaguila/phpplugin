<?php

/*
Plugin Name: dl Eagle Functions
Plugin URI: http://www.dleagle.net
Description: Functions Developed by dl Eagle Team
Version: 1.0
Author: Julio del Aguila
Author URI: http://www.dleagle.net
*/

/*Creating a Widget*/
class jpen_Example_Widget extends WP_Widget {
  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array( 'classname' => 'example_widget', 'description' => 'Format Field Filter Widget' );
    parent::__construct( 'example_widget', 'Format Field Filter', $widget_options );
  }

  // Create the widget output.
  public function widget( $args, $instance ) {
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<div id="archive-filters">
<?php
$id_field = "field_5b7d848c4b991"; 
$field_name = 'format';
$post_id = get_the_ID();
	// get the field's settings without attempting to load a value
	//$field = get_field_object($field_name);
	$field = get_field_object($id_field);
	// set value if available
	//if( isset($_GET[ $field_name ]) ) {
		//$field['value'] = explode(',', $_GET[ $field_name ]);
	//}
	$checked_fields = isset($_GET[ $field_name ]) ? explode(',', $_GET[ $field_name ]) : array();
?>
	<div id="checks" class="filter widget_text et_pb_widget widget_custom_html"  data-filter="<?php echo $field_name;?>">
		<div class=class="textwidget custom-html-widget">		
		<div ><font face="Arial" style="font-size: 16pt" color="#008000"><b><?php echo ucwords($field_name);?><br></br></b></font></div>
			<div >
				<ul class="product-categories">	
					<?php foreach($field['choices'] as $choice_value => $choice_label): ?>
					<li>
						<input type="checkbox" value="<?php echo $choice_value; ?>" <?php if(in_array($choice_value, $checked_fields)): ?> checked="checked" <?php endif; ?> /> 
						<font style="font-size: 12pt" color="#000099"><?php echo $choice_label; ?></font>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>			
</div>
<div id="label-filters">
<?php
$id_label = "field_5b7d84594b990"; 
$label_name = 'label';
$post_id = get_the_ID();
	// get the label's settings without attempting to load a value
	//$field = get_field_object($field_name);
	$label = get_field_object($id_label);
	// set value if available
	//if( isset($_GET[ $field_name ]) ) {
		//$field['value'] = explode(',', $_GET[ $field_name ]);
	//}
	$checked_labels = isset($_GET[ $label_name ]) ? explode(',', $_GET[ $label_name ]) : array();
?>
	<div id="labelchecks" class="filter widget_text et_pb_widget widget_custom_html"  data-filter="<?php echo $label_name;?>">
		<div class=class="textwidget custom-html-widget">		
		<div ><font face="Arial" style="font-size: 16pt" color="#008000"><b><?php echo ucwords($label_name);?><br></br></b></font></div>
			<div >
				<select id="multiSelect" name="multiSelect" multiple>	
					<?php foreach($label['choices'] as $choice_value => $choice_label): ?>
					<option value="<?php echo $choice_value; ?>" <?php if(in_array($choice_value, $checked_labels)): ?> selected="selected" <?php endif; ?> >
						<font style="font-size: 12pt" color="#000099"><?php echo $choice_label; ?></font>
					</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>			
</div>
<script type="text/javascript">

	$('#multiSelect').multiselect({
		deselectAll: false,
  nonSelectedText: 'Select Label',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true
});

(function($) {
	// change
	//alert("llega a la funcion");
	$("#archive-filters").on('change', 'input[type="checkbox"]', function(){
		// vars
		//var url = '<?php echo home_url('shop'); ?>' + '/';
		var field_name = 'format';
		//var url = '<?php echo get_current_url_path(); ?>' + '/';
		//var url = '<?php echo set_url_filter_ready(); ?>';		
		var url = '<?php echo get_parameters(); ?>';
		var cont = 0;
		args = {};
		// loop over filters
		$("#archive-filters .filter").each(function(){
			// vars
			var filter = $(this).data('filter'), vals = [];
			// find checked inputs
			$("#checks").find('input:checked').each(function(){
				vals.push( $(this).val() );
				cont = cont + 1;
			});
			// append to args
			args[ filter ] = vals.join(',');
		});
		
		if (cont > 0)
		{		
			// update url
			//url += '?';
			// loop over args
			$.each(args, function( name, value ){
				url += name + '=' + value + '&';
			});
		}
			// remove last &
			url = url.slice(0, -1);
		// reload page
		window.location.replace( url );
		//location.reload(true);
		//location = url;
	});
	
	$("#label-filters").on('change', function(){
		var field_name = 'label';
		var url = '<?php echo get_parameters_label(); ?>';
		var cont = 0;
		args = {};
		$("#label-filters .filter").each(function(){
			var filter = $(this).data('filter'), vals = [];
			$("#labelchecks").find('option:selected').each(function(){
				vals.push( $(this).val() );
				cont = cont + 1;
			});
			args[ filter ] = vals.join(',');
		});
		
		if (cont > 0)
		{		
			$.each(args, function( name, value ){
				if(name != 'undefined')
				{
					url += name + '=' + value + '&';
				}
			});
		}
			url = url.slice(0, -1);
		window.location.replace( url );
	});

})(jQuery);
</script>
    <?php
  }
 
  // Create the admin area widget settings form.
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p><?php
  }

  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    return $instance;
  }
}

// Register the widget.
function jpen_register_example_widget() { 
  register_widget( 'jpen_Example_Widget' );
}
add_action( 'widgets_init', 'jpen_register_example_widget' );

?>

<?php
/*Getting Current Url Path*/
function get_current_url_path(){
	//$uri = $_SERVER['REQUEST_URI'];
	//echo $uri; // Outputs: URI
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	//echo $url; // Outputs: Full URL
	$query = $_SERVER['QUERY_STRING'];
	$path = str_replace('?'.$query, "", $url);
	//echo $query; // Outputs: Query String
	return $path;
}

/*Getting Current Url Path*/
function set_url_filter_ready(){
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$query = trim($_SERVER['QUERY_STRING']);
	$path = $url;
	if(!empty($query))
	{
		$pos = strpos($query, 'format');
		if($pos !== false)
		{
			$pos_amp = strpos($query, '&', $pos + 1);
			if($pos_amp !== false)
			{
				$str_format = substr($query,$pos,$pos_amp - $pos + 1);
				$path = str_replace($str_format, "", $url);
			}
			else
			{
				$str_format = substr($query,$pos);
				$path = str_replace($str_format, "", $url) . '&';
			}
		}
	}
	else
	{
		$path = $path . '?';
	}
	//echo $query; // Outputs: Query String
	return $path;
}

function get_parameters()
{
	$field_name = 'format';
		$url_param = '?';
		foreach($_GET as $key => $value)
		{
			if($key != $field_name)
			{
				$url_param = $url_param . $key . '=' . $value . '&';
			}
		};
	return get_current_url_path() . $url_param;//$_GET($url);
}

function get_parameters_label()
{
	$field_name = 'label';
		$url_param = '?';
		foreach($_GET as $key => $value)
		{
			if($key != $field_name)
			{
				$url_param = $url_param . $key . '=' . $value . '&';
			}
		};
	return get_current_url_path() . $url_param;//$_GET($url);
}

// action
add_action('pre_get_posts', 'my_pre_get_posts', 10, 1);

function my_pre_get_posts($query)
{
	//echo "es llamado";
	// bail early if is in admin
	if( is_admin() ) return;
	// bail early if not main query
	// - allows custom code / plugins to continue working
	if( !$query->is_main_query() ) return;
	// get meta query
	$meta_query = $query->get('meta_query');
	$name = 'format';
	$name1 = 'label';
	if( !empty($_GET[ $name ]) || !empty($_GET[ $name1 ]))
	{
		$value = explode(',', $_GET[ $name ]);
		$value1 = explode(',', $_GET[ $name1 ]);
		if( !empty($_GET[ $name ]) && !empty($_GET[ $name1 ]))
		{
			$meta_query = array(
			'relation' => 'AND',
			array(
			'key'     => 'format',
			'value'   => $value,
			'compare'	=> 'IN'		
			),
			array(
			'key'     => 'label',
			'value'   => $value1,
			'compare'	=> 'IN'		
			)
			);
		}
		elseif(!empty($_GET[ $name ]))
		{
			$meta_query = array(
			array(
			'key'     => 'format',
			'value'   => $value,
			'compare'	=> 'IN'		
			)
			);
		}else{
			$meta_query = array(
			array(
			'key'     => 'label',
			'value'   => $value1,
			'compare'	=> 'IN'		
			)
			);
		}
		/*$meta_query = array(
			'relation' => 'AND',
			array(
			'key'     => 'format',
			'value'   => $value,
			'compare'	=> 'IN'		
			),
			array(
			'key'     => 'label',
			'value'   => $value1,
			'compare'	=> 'IN'		
			)
		);*/
		// update meta query
		$query->set('meta_query', $meta_query);
	}
}

/*Planning to Make a Button*/
function fn_de_testing()
{
	echo 'hi';
}

add_shortcode('de_testing', 'fn_de_testing');
/*Using an example from Internet to create a button*/

function fn_de_button($atts, $content = null) {
   extract(shortcode_atts(array('link' => '#'), $atts));
   return '<a class="de_button" href="'.$link.'"><span>' . do_shortcode($content) . '</span></a>';
}

add_shortcode('de_button', 'fn_de_button');

/*STEP 1 - REMOVE ADD TO CART BUTTON ON PRODUCT ARCHIVE (SHOP) */

function remove_loop_button(){
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

/*STEP 2 -ADD NEW BUTTON THAT LINKS TO PRODUCT PAGE FOR EACH PRODUCT */

add_action('woocommerce_after_shop_loop_item','replace_add_to_cart');

function replace_add_to_cart() {
global $product;
$link = $product->get_permalink();
echo do_shortcode('<br>[de_button link="' . esc_attr($link) . '" ]<font color="white">BUY NOW</font>[/de_button]');
}

/*Aug 22 2018*/
add_action('woocommerce_before_add_to_cart_form','print_something_below_short_description');

function print_something_below_short_description()
{
	echo "<b>ITEM: </b>"; the_ID();	echo "</br>";	
	echo "<b>ARTIST: </b>";	the_field('artist'); echo "</br>";
	echo "<b>TITLE: </b>"; the_field('title'); echo "</br>";
	echo "<b>LABEL: </b>"; the_field('label'); echo "</br>";
	echo "<b>CATALOG #: </b>"; the_field('category'); echo "</br>";
	echo "<b>SPEED: </b>"; the_field('speed'); echo "</br>";
	if(get_field('format')){
		echo "<b>FORMAT: </b>";
		//the_field('format');		
		$format_value = get_field('format');
		$field = get_field_object('format');
		$format_label = $field['choices'][ $format_value ];
		echo $format_label;
		echo "</br>";
	}
	echo "<b>ATTRIBUTES: </b>";	the_field('attributes'); echo "</br>";
	echo "<b>GRADES: </b>"; the_field('grade');	echo "</br>";
	echo "<b>GENRE: </b>"; the_field('genre'); echo "</br>";
	echo "<b>SUB-GENRE: </b>"; the_field('sub-genre'); echo "</br>";
	echo "<b>DURATION: </b>"; the_field('duration'); echo "</br>";
	echo "<b>ORIGIN: </b>"; the_field('made_in'); echo "</br>";
	echo "</p>";	
}

/* products per page with - this fixes it when using divi */

add_action( 'pre_get_posts', 'wppp_extra_filter', 30 );

function wppp_extra_filter( $query = false ) {
$query->set( 'posts_per_page', apply_filters( 'loop_shop_per_page', 20 ) );
}


/*This function will show the template file used in a page*/
function show_template() {

    if( is_super_admin() ){

        global $template;
        print_r($template);
    } 
}
add_action('wp_footer', 'show_template');
?>