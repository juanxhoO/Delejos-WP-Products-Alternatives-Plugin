<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://dssd
 * @since      1.0.0
 *
 * @package    Product_Alternatives
 * @subpackage Product_Alternatives/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Product_Alternatives
 * @subpackage Product_Alternatives/public
 * @author     Juan GRanja <ggjuanb@hotmail.com>
 */
class Product_Alternatives_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Alternatives_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Alternatives_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/product-alternatives-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Alternatives_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Alternatives_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/product-alternatives-public.js', array('jquery'), $this->version, false);

	}


	//Adding Products form Extras to the cart Page
	public function display_products_from_specific_category_in_cart()
	{
		// Get the specific category ID or slug
		$category_id = 'extra-products';

		// Query products from the specified category
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'product_cat' => $category_id,
		);
		$query = new WP_Query($args);

		// Check if there are products in the category
		if ($query->have_posts()) {

			echo '<div class="row extra_aditionals_container">';
			echo '<h2 class="aditionals_title">Aditionals Products</h2>';
			while ($query->have_posts()) {
				$query->the_post();
				// Display product information here
				wc_get_template_part('content', 'product');
			}
			wp_reset_postdata();
			echo '</div>';
		}
	}


	public function exclude_category_from_shop_page($query)
	{
		if (is_admin() || !$query->is_main_query()) {
			return;
		}

		if (!is_cart() || !is_checkout()) {

			$exclude_category_slug = 'extra-products'; // Replace 'your-category-slug' with the slug of the category you want to exclude.
			$term = get_term_by('slug', $exclude_category_slug, 'product_cat');
			if ($term) {
				$query->set(
					'tax_query',
					array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'id',
							'terms' => $term->term_id,
							'operator' => 'NOT IN',
						),
					)
				);
			}

		}


	}



	public function hide_aditionals_from_shortcode($query)
	{


		//excludin
		$excluded_category_slug = 'extra-products'; // Replace with the slug of the category you want to exclude.

		// Get the category ID by slug.
		$excluded_category = get_term_by('slug', $excluded_category_slug, 'product_cat');

		if ($excluded_category && isset($excluded_category->term_id)) {
			$excluded_category_id = $excluded_category->term_id;

			// Add a 'tax_query' to exclude products from the specified category.
			$query['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => $excluded_category_id,
				'operator' => 'NOT IN',
			);
		}

		return $query;

	}
}