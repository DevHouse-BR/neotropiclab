<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package vslmd
 */

if ( ! function_exists( 'vslmd_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function vslmd_paging_nav( $args = array() ) {
	$defaults = array(
		'echo' => true,
		'query' => $GLOBALS['wp_query'],
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('Previous', 'vslmd'),
		'next_text' => __('Next', 'vslmd'),	
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract($args, EXTR_SKIP);
	// Stop execution if there's only 1 page
	if( $query->max_num_pages <= 1 ) {
		return;
	}	
	
	$pagination = '';
	$links = array();
	
	$paged = max( 1, absint( $query->get( 'paged' ) ) );
	$max   = intval( $query->max_num_pages );
	
	if ( $show_all ) {
		$links = range(1, $max);	
	} else {
		// Add the pages before the current page to the array
		if ( $paged >= 2 + 1 ) {
			$links[] = $paged - 2;
			$links[] = $paged - 1;
		}
		
		// Add current page to the array
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}
		
		// Add the pages after the current page to the array
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 1;
			$links[] = $paged + 2;
		}
	}
	
	$pagination .= '<nav class="text-center"><ul class="pagination">';
	// Previous Post Link
	if ( $prev_next && get_previous_posts_link() ) {
		$pagination .= sprintf( '<li class="prev">%s</li>', get_previous_posts_link('&laquo;<span class="sr-only">' . $prev_text . '</span>') );
	}
		
	// Link to first page, plus ellipses if necessary
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );	
		if ( ! in_array( 2, $links ) ) {
			$pagination .= '<li class="ellipsis"><span>' .'&hellip;'. '</span></li>';
		}	
	}
	// Link to current page, plus $mid_size pages in either direction if necessary
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
	}
	// Link to last page, plus ellipses if necessary
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) ) {
			$pagination .= '<li class="ellipsis"><span>' .'&hellip;'. '</span></li>';
		}
		$class = $paged == $max ? ' class="active"' : '';
		$pagination .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $max ) ), $max );	
	}
	// Next Post Link
	if ( $prev_next && get_next_posts_link() && $paged <= $max ) {
		$pagination .= sprintf( '<li class="next">%s</li>', get_next_posts_link('<span class="sr-only">' . $next_text . '</span>&raquo;') );		
	}
	$pagination .= '</ul></nav>';
	
	if ( $echo ) {
		echo $pagination;
	} else {
		return $pagination;
	}
}
endif;

if ( ! function_exists( 'vslmd_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function vslmd_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'vslmd' ); ?></h1>
		<ul class="pager">
			<?php
				previous_post_link( '<li class="previous">%link</li>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'vslmd' ) );
				next_post_link(     '<li class="next">%link</li>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'vslmd' ) );
			?>
		</ul><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'vslmd_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function vslmd_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'vslmd' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'vslmd' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'vslmd_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function vslmd_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'vslmd' ) );
		if ( $categories_list && vslmd_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'vslmd' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'vslmd' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'vslmd' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'vslmd' ), __( '1 Comment', 'vslmd' ), __( '% Comments', 'vslmd' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'vslmd' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'vslmd' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'vslmd' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'vslmd' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'vslmd' ), get_the_date( _x( 'Y', 'yearly archives date format', 'vslmd' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'vslmd' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'vslmd' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'vslmd' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'vslmd' ) ) );
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = _x( 'Asides', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$title = _x( 'Galleries', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = _x( 'Images', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = _x( 'Videos', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = _x( 'Quotes', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = _x( 'Links', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$title = _x( 'Statuses', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$title = _x( 'Audio', 'post format archive title', 'vslmd' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$title = _x( 'Chats', 'post format archive title', 'vslmd' );
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'vslmd' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'vslmd' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'vslmd' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function vslmd_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'vslmd_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'vslmd_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so vslmd_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so vslmd_categorized_blog should return false.
		return false;
	}
}

/**
 * Breadcrumbs for footer.
 */

function vslmd_breadcrumbs() {
 
    /* === OPTIONS === */
    $text['home']     = __( 'Home', 'vslmd' ); // text for the 'Home' link
    $text['category'] = __( 'Archive by Category "%s"', 'vslmd' ); // text for a category page
    $text['search']   = __( 'Search Results for "%s" Query', 'vslmd' ); // text for a search results page
    $text['tag']      = __( 'Posts Tagged "%s"', 'vslmd' ); // text for a tag page
    $text['author']   = __( 'Articles Posted by %s', 'vslmd' ); // text for an author page
    $text['404']      = __( 'Error 404', 'vslmd' ); // text for the 404 page
 
    $show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
    $show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
    $show_title     = 1; // 1 - show the title for the links, 0 - don't show
    $delimiter      = ' <i class="fa fa-angle-right"></i> '; // delimiter between crumbs
    $before         = '<span class="current">'; // tag before the current crumb
    $after          = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */
 
    global $post;
    $home_link    = home_url('/');
    $link_before  = '<span typeof="v:Breadcrumb">';
    $link_after   = '</span>';
    $link_attr    = ' rel="v:url" property="v:title"';
    $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $parent_id    = $parent_id_2 = $post->post_parent;
    $frontpage_id = get_option('page_on_front');
 
    if (is_home() || is_front_page()) {
 
        if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
 
    } else {
 
        echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
        if ($show_home_link == 1) {
            echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
        }
 
        if ( is_category() ) {
            $this_cat = get_category(get_query_var('cat'), false);
            if ($this_cat->parent != 0) {
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
 
        } elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;
 
        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;
 
        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;
 
        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;
 
        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
                if ($show_current == 1) echo $before . get_the_title() . $after;
            }
 
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
 
        } elseif ( is_attachment() ) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
 
        } elseif ( is_page() && !$parent_id ) {
            if ($show_current == 1) echo $before . get_the_title() . $after;
 
        } elseif ( is_page() && $parent_id ) {
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs)-1) echo $delimiter;
                }
            }
            if ($show_current == 1) {
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
                echo $before . get_the_title() . $after;
            }
 
        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
 
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;
 
        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }
 
        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }
 
        echo '</div><!-- .breadcrumbs -->';
 
    }
}

/**
 * Flush out the transients used in vslmd_categorized_blog.
 */
function vslmd_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'vslmd_categories' );
}
add_action( 'edit_category', 'vslmd_category_transient_flusher' );
add_action( 'save_post',     'vslmd_category_transient_flusher' );
