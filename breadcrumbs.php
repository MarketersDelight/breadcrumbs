<?php
/**
 * Drop-in Name: Breadcrumbs
 * Description: Add contextual navigation trails throughout your site.
 * Author: Alex, Kolakube
 * Author URI: https://marketersdelight.com/
 * Drop-in URI: https://marketersdelight.com/dropins/breadcrumbs/
 * Drop-in Slug: breadcrumbs
 * Text Domain: md-breadcrumbs
 * Version: 1.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 */

class md_breadcrumbs extends md_api {

	/**
	 * Register Breadcrumb admin integrations.
	 *
	 * @since 1.0
	 */

	public function actions() {
		if ( ! is_admin() )
			return;

		add_filter( 'md_filter_save_layout_fields', array( $this, 'layout_fields' ) );
		add_action( 'md_hook_layout_content_fields', array( $this, 'layout_field' ), 10, 2 );
		add_action( 'md_hook_admin_after_tools', array( $this, 'admin_page' ) );
	}

	/**
	 * Register global and Layout settings.
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'admin_page' => array(
				'name' => __( 'Breadcrumbs', 'md-breadcrumbs' ),
				'fields' => array(
					'home_label' => array( 'type' => 'text' ),
					'simple_link' => array(
						'type' => 'checkbox',
						'options' => array( 'enable' )
					)
				)
			)
		);
	}

	/**
	 * Render global Breadcrumb settings.
	 *
	 * @since 1.0
	 */

	public function admin_page() {
		include md_template( 'dropins', 'breadcrumbs/admin-page', true );
	}

	/**
	 * Add Breadcrumbs to Layout's save schema.
	 *
	 * @since 1.0
	 */

	public function layout_fields( $fields ) {
		$fields['breadcrumbs'] = array(
			'type' => 'checkbox',
			'options' => array( 'add', 'remove' )
		);

		return $fields;
	}

	/**
	 * Render Add/Remove against the setting inherited by this screen.
	 *
	 * @since 1.0
	 */

	public function layout_field( $fields, $context ) {
		$post_type = $context['post_type'];
		$inherited = array();

		if ( $context['is_admin'] && ! $context['is_taxonomy'] ) {
			$settings_post_type = $context['settings_post_type'] ?? $post_type;
			$parent = md_post_type_settings_parent( $settings_post_type );

			if ( $parent && $parent !== $settings_post_type )
				$inherited = md_post_type_field( array( 'layout', 'breadcrumbs' ), array(), $parent );
		}
		else {
			$inherited = md_post_type_field( array( 'layout', 'breadcrumbs' ), array(), $post_type );

			if ( $context['is_term'] )
				$inherited = md_taxonomy_field( array( 'layout', 'breadcrumbs' ), $inherited, $post_type, $context['taxonomy'] );
		}

		$enabled = ! empty( $inherited['add'] ) && empty( $inherited['remove'] );
		$options = $enabled ? array(
			'remove' => __( 'Remove <b>Breadcrumbs</b>', 'md-breadcrumbs' )
		) : array(
			'add' => __( 'Add <b>Breadcrumbs</b>', 'md-breadcrumbs' )
		);

		$fields->field( 'breadcrumbs', array(
			'type' => 'checkbox',
			'options' => $options
		) );
	}

	/**
	 * Add Breadcrumbs to MD's compiled stylesheet.
	 *
	 * @since 1.0
	 */

	public function css( $templates ) {
		$templates['breadcrumbs'] = md_css( 'dropins', 'breadcrumbs/css', true );

		return $templates;
	}

	/**
	 * Add the renderer to MD's content area.
	 *
	 * @since 1.0
	 */

	public function template() {
		add_action( 'md_hook_content', array( $this, 'render' ) );
	}

	/**
	 * Check the fully inherited Breadcrumbs setting for this request.
	 *
	 * @since 1.0
	 */

	public function has() {
		$settings = md_module( array( 'layout', 'breadcrumbs' ), null );

		if ( is_null( $settings ) )
			$settings = md_post_type_field( array( 'layout', 'breadcrumbs' ), array() );

		return ! empty( $settings['add'] ) && empty( $settings['remove'] );
	}

	/**
	 * Render the resolved trail through the overrideable HTML template.
	 *
	 * @since 1.0
	 */

	public function render() {
		if ( ! $this->has() )
			return;

		$breadcrumbs = $this->get();

		if ( count( $breadcrumbs ) < 2 && ! isset( $breadcrumbs['archive-link'] ) )
			return;

		include md_template( 'dropins', 'breadcrumbs/breadcrumbs', true );
	}

	/**
	 * Determine breadcrumbs to show based on WP page types.
	 *
	 * @since 1.0
	 */

	public function get() {
		$blog = $archive = $breadcrumbs = array();
		$blog_id = absint( get_option( 'page_for_posts' ) );

		if ( $blog_id )
			$blog = array(
				'label' => get_the_title( $blog_id ),
				'url' => get_permalink( $blog_id )
			);

		$query_post_type = get_query_var( 'post_type' );

		if ( is_array( $query_post_type ) ) {
			$archive_types = array();

			foreach ( $query_post_type as $type ) {
				$object = get_post_type_object( $type );

				if ( $object && $object->has_archive )
					$archive_types[] = $type;
			}

			$query_post_type = count( $archive_types ) === 1 ? reset( $archive_types ) : '';
		}

		if ( is_string( $query_post_type ) && $query_post_type && $query_post_type !== 'post' ) {
			$post_type = get_post_type_object( $query_post_type );

			if ( $post_type && $post_type->has_archive )
				$archive = array(
					'label' => $post_type->labels->name,
					'url' => get_post_type_archive_link( $post_type->name )
				);
		}

		$home_label = md_setting( array( 'breadcrumbs', 'home_label' ), '' );
		$home_label = is_string( $home_label ) ? trim( $home_label ) : '';

		$breadcrumbs['home'] = array(
			'label' => $home_label ?: __( 'Home', 'md-breadcrumbs' ),
			'url' => home_url( '/' )
		);

		if ( is_search() )
			$breadcrumbs['search'] = array(
				'label' => sprintf( __( 'Search results: %s', 'md-breadcrumbs' ), get_search_query() ),
				'url' => ''
			);
		elseif ( is_404() )
			$breadcrumbs['404'] = array(
				'label' => __( 'Nothing Found', 'md-breadcrumbs' ),
				'url' => ''
			);
		elseif ( is_date() ) {
			if ( $archive )
				$breadcrumbs['archive'] = $archive;
			elseif ( $blog )
				$breadcrumbs['blog'] = $blog;

			$year = absint( get_query_var( 'year' ) );
			$month = absint( get_query_var( 'monthnum' ) );
			$day = absint( get_query_var( 'day' ) );

			if ( is_month() || is_day() )
				$breadcrumbs['year'] = array(
					'label' => $year,
					'url' => md_get_date_archive_link( $year, 0, 0, array( 'post_type' => $query_post_type ) )
				);

			if ( is_day() )
				$breadcrumbs['month'] = array(
					'label' => wp_date( 'F', mktime( 0, 0, 0, $month, 1, $year ) ),
					'url' => md_get_date_archive_link( $year, $month, 0, array( 'post_type' => $query_post_type ) )
				);

			if ( is_year() )
				$date = $year;
			elseif ( is_month() )
				$date = wp_date( 'F Y', mktime( 0, 0, 0, $month, 1, $year ) );
			else
				$date = wp_date( get_option( 'date_format' ), mktime( 0, 0, 0, $month, $day, $year ) );

			$breadcrumbs['current'] = array(
				'label' => $date,
				'url' => ''
			);
		}
		elseif ( is_author() ) {
			if ( $archive )
				$breadcrumbs['archive'] = $archive;
			elseif ( $blog )
				$breadcrumbs['blog'] = $blog;

			$author = get_queried_object();
			$breadcrumbs['author'] = array(
				'label' => ! empty( $author->display_name ) ? $author->display_name : __( 'Author', 'md-breadcrumbs' ),
				'url' => ''
			);
		}
		elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();

			if ( $term && ! is_wp_error( $term ) ) {
				if ( in_array( $term->taxonomy, array( 'category', 'post_tag' ), true ) ) {
					if ( $blog )
						$breadcrumbs['blog'] = $blog;
				}
				else {
					$taxonomy = get_taxonomy( $term->taxonomy );
					$archives = array();

					foreach ( $taxonomy ? (array) $taxonomy->object_type : array() as $object_type ) {
						$post_type = get_post_type_object( $object_type );

						if ( $post_type && $post_type->has_archive )
							$archives[$object_type] = $post_type;
					}

					if ( count( $archives ) === 1 ) {
						$post_type = reset( $archives );
						$breadcrumbs['archive'] = array(
							'label' => $post_type->labels->name,
							'url' => get_post_type_archive_link( $post_type->name )
						);
					}
				}

				foreach ( array_reverse( get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' ) ) as $ancestor_id ) {
					$ancestor = get_term( $ancestor_id, $term->taxonomy );

					if ( ! $ancestor || is_wp_error( $ancestor ) )
						continue;

					$breadcrumbs["term-{$ancestor_id}"] = array(
						'label' => $ancestor->name,
						'url' => get_term_link( $ancestor )
					);
				}

				$breadcrumbs['term'] = array(
					'label' => $term->name,
					'url' => ''
				);
			}
		}
		elseif ( is_home() ) {
			if ( $blog ) {
				$blog['url'] = '';
				$breadcrumbs['blog'] = $blog;
			}
		}
		elseif ( is_post_type_archive() ) {
			$post_type = get_queried_object();

			if ( ! $post_type || empty( $post_type->name ) )
				$post_type = get_post_type_object( md_get_post_type() );

			if ( $post_type )
				$breadcrumbs['archive'] = array(
					'label' => $post_type->labels->name,
					'url' => ''
				);
		}
		elseif ( is_singular() ) {
			$post_id = get_queried_object_id() ?: get_the_ID();
			$post_type_name = get_post_type( $post_id );
			$post_type = get_post_type_object( $post_type_name );

			if ( $post_type_name === 'post' ) {
				if ( $blog )
					$breadcrumbs['blog'] = $blog;

				$categories = get_the_category( $post_id );

				if ( ! empty( $categories ) ) {
					$category = reset( $categories );

					foreach ( array_reverse( get_ancestors( $category->term_id, 'category', 'taxonomy' ) ) as $ancestor_id ) {
						$ancestor = get_term( $ancestor_id, 'category' );

						if ( ! $ancestor || is_wp_error( $ancestor ) )
							continue;

						$breadcrumbs["category-{$ancestor_id}"] = array(
							'label' => $ancestor->name,
							'url' => get_term_link( $ancestor )
						);
					}

					$breadcrumbs['category'] = array(
						'label' => $category->name,
						'url' => get_term_link( $category )
					);
				}
			}
			elseif ( $post_type_name !== 'page' && $post_type && $post_type->has_archive )
				$breadcrumbs['archive'] = array(
					'label' => $post_type->labels->name,
					'url' => get_post_type_archive_link( $post_type_name )
				);

			if ( $post_type_name === 'page' || ( $post_type && $post_type->hierarchical ) )
				foreach ( array_reverse( get_post_ancestors( $post_id ) ) as $ancestor_id ) {
					$breadcrumbs["post-{$ancestor_id}"] = array(
						'label' => get_the_title( $ancestor_id ),
						'url' => get_permalink( $ancestor_id )
					);
				}

			$breadcrumbs['current'] = array(
				'label' => get_the_title( $post_id ),
				'url' => ''
			);
		}

		if ( get_query_var( 'filter' ) ) {
			$keys = array_keys( $breadcrumbs );
			$current = end( $keys );

			if ( $current && empty( $breadcrumbs[$current]['url'] ) )
				$breadcrumbs[$current]['url'] = remove_query_arg( 'filter', get_pagenum_link( 1 ) );

			$breadcrumbs['filter'] = array(
				'label' => __( 'Filter results', 'md-breadcrumbs' ),
				'url' => ''
			);
		}

		if ( is_paged() ) {
			$keys = array_keys( $breadcrumbs );
			$current = end( $keys );

			if ( $current && empty( $breadcrumbs[$current]['url'] ) )
				$breadcrumbs[$current]['url'] = get_pagenum_link( 1 );

			$breadcrumbs['page'] = array(
				'label' => sprintf( __( 'Page %s', 'md-breadcrumbs' ), number_format_i18n( max( 1, get_query_var( 'paged' ) ) ) ),
				'url' => ''
			);
		}

		$breadcrumbs = apply_filters( 'md_filter_breadcrumbs', $breadcrumbs );

		return $this->simple_link_link( $breadcrumbs );
	}

	/**
	 * Replace a singular trail with a compact post type archive link.
	 *
	 * @since 1.0
	 */

	protected function simple_link_link( $breadcrumbs ) {
		if ( ! is_singular() || ! md_setting( array( 'breadcrumbs', 'simple_link', 'enable' ) ) )
			return $breadcrumbs;

		$post_id = get_queried_object_id() ?: get_the_ID();
		$post_type_name = get_post_type( $post_id );
		$post_type = get_post_type_object( $post_type_name );
		$url = '';

		if ( $post_type_name === 'post' ) {
			$blog_id = absint( get_option( 'page_for_posts' ) );
			$url = $blog_id ? get_permalink( $blog_id ) : home_url( '/' );
		}
		elseif ( $post_type && $post_type->has_archive )
			$url = get_post_type_archive_link( $post_type_name );

		if ( ! $post_type || ! $url )
			return $breadcrumbs;

		return array(
			'archive-link' => array(
				'label' => sprintf( __( '← All %s', 'md-breadcrumbs' ), $post_type->labels->name ),
				'url' => $url
			)
		);
	}

}

new md_breadcrumbs;
