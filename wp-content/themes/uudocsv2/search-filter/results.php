<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if (! defined('ABSPATH')) {
    exit;
}

if ($query->have_posts()) {

    while ($query->have_posts()) {
        $query->the_post();

        $icon_name = '';
        $release_note_taxonomies = [];
        $pill_terms = [];
        $custom_taxonomies = ['product', 'feature', 'user'];

        foreach ($custom_taxonomies as $main_index => $taxonomy) {
            $release_note_taxonomies[$taxonomy] = wp_get_post_terms(get_the_ID(), $taxonomy);
        }

        // pill taxonomies
        foreach ($release_note_taxonomies as $term => $terms) {
            foreach ($terms as $tax) {
                $pill_terms[$term] = $tax->slug;
            }
        }

        $link = get_the_permalink();
        $external_link = get_field('external_link');

        $target = '';

        if ($external_link) {
            $link = $external_link;
            $target = ' target="_blank"';
        }

        $img_id = get_post_thumbnail_id(get_the_ID());
        $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
        ?>

        <?php if (is_page('search-results')) : ?>
            <h3 class="mb-4 text-2xl font-bold">
                <a
                    class="no-underline text-brand"
                    href="<?php echo $link; ?>" <?php echo $target; ?>>
                    <?php the_title(); ?>
                </a>
            </h3>
            <?php the_excerpt(); ?>
<?php else: ?>

<style>
    .logo-icon svg {
        width: 20px;
        height: 20px;
    }
    #kb-search-results .rl-items .rl-item:last-child .rl-line {
        display:none;
    }
</style>

<div class="rl-items flex flex-col">
    <div class="rl-item flex md:grid md:grid-cols-12 mb-4">

        <div class="col-span-4">
            <div class="flex flex-col gap-2 md:gap-10 md:grid md:grid-cols-2 h-full">
                <div class="font-semibold text-action">
                    <span class="hidden md:block">
                        <?php echo get_the_date('F d, Y', get_the_ID()); ?>
                    </span>
                    <span class="w-24 block md:hidden not-sr-only">
                        <?php echo get_the_date('M d,<\b\\r> Y'); ?>
                    </span>
                </div>

                <div class="relative flex flex-col items-center h-full mr-10">
                    <div class="rl-line absolute w-[2px] top-12 bottom-0 bg-pale-blue" style="margin-left: -2px;"></div>
                        <?php foreach ($release_note_taxonomies as $index => $taxonomies): ?>

                            <?php if (is_array($taxonomies)) : ?>
                                <?php foreach ($taxonomies as $tax) : ?>
                                    <?php if ($tax) : ?>
                                        <?php $extras = get_field('product', $tax->taxonomy . '_' . $tax->term_id); ?>

                                        <?php if ($tax->taxonomy == 'product') : ?>
                                            <?php $icon_name = $tax->slug; ?>
                                            <span class="text-action relative z-10 mb-2 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border text-sm font-medium shadow-md bg-white">
                                                <?php if ($extras) : ?>
                                                    <?php $icon = $extras['icon']; ?>
                                                <?php endif; ?>
                                                <?php if (file_exists(get_template_directory().'/resources/icons/acf/' . $icon . '.svg')): ?>
                                                    <span class="w-5 h-5 text-action logo-icon">
                                                        <?php echo file_get_contents(get_template_directory().'/resources/icons/acf/' . $icon . '.svg'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                   <?php break; // show first icon only ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-span-7 pb-10 relative group">
                <h3 class="mb-4 text-2xl font-bold">
                    <a
                        class="no-underline text-brand group-hover:text-action"
                        href="<?php echo $link; ?>" <?php echo $target; ?>>
                    <?php the_title(); ?>
                    </a>
                </h3>

                <?php the_excerpt(); ?>

                <?php

                global $wp;

                $query_string = '';
                $current_url = $_SERVER['REQUEST_URI'];

                $filters = ['_sft_product', '_sft_feature', '_sft_user'];
                $filter_names = ['product', 'feature', 'user'];

                $the_query_string = explode('?', $current_url);

                if (isset($the_query_string[1])) {
                    $query_string = $the_query_string[1];
                    $query_vars = explode('&', $query_string);
                } else {
                    $query_vars = [];
                }

                $new_filters = [];

                foreach ($query_vars as $index => $var) {
                    $key_value = explode('=', $var);

                    if (in_array($key_value[0], $filters)) {
                        $name = str_replace('_sft_', '', $key_value[0]);
                        if (in_array($key_value[0], $filters)) {
                            $new_filters[$name] = $key_value[1];
                        }
                    }
                }

                $c_filter = [];
                $query_filters = [];
                $merged_filters = [];
                $c_filter = [];

                if ($new_filters) {
                    foreach ($new_filters as $product => $value) {
                        $query_filters[$product] = explode('+', $value);

                    }
                }
                ?>


                <div class="flex flex-wrap gap-2 my-4 relative z-30">
                    <?php foreach ($release_note_taxonomies as $index => $taxonomies) : ?>
                        <?php
                            $unique_filters = [];
                            $combined_filters = '';
                            $merged_filters = [];
                            $filters = [];
                            $pill_terms2 = [];
                            $combined_filters = '';
                        ?>
                        <?php if ($taxonomies) : ?>
                            <?php foreach ($taxonomies as $taxonomy) : ?>
                                <?php
                                $pill_terms2 = [];
                                $pill_terms3 = [];
                                $pill_link = "/release-notes/?";
                                if (isset($pill_terms[$taxonomy->taxonomy])) {
                                    $pill_terms2[$taxonomy->taxonomy][] = $taxonomy->slug;
                                }


                                foreach ($pill_terms2 as $index => $terms) {
                                    $pill_terms3[$index] = array_merge($terms);
                                }

                                $merged_filters = array_merge_recursive($query_filters, $pill_terms3);

                                if ($new_filters) {

                                    foreach ($custom_taxonomies as $index => $term) {

                                        $string = '';


                                        if ($term == $taxonomy->taxonomy) {
                                            $combined_filters = '';

                                            foreach ($merged_filters as $var => $filters) {
                                                if (is_array($filters)) {
                                                $filters = array_unique($filters);
                                                $combined_filters .= '&_sft_' . $var . '=' . implode('+', $filters);
                                                }
                                            }
                                        }

                                        $pill_link = '?' . $combined_filters;
                                    }
                                } else {
                                    $pill_link .= "_sft_{$taxonomy->taxonomy}={$taxonomy->slug}";
                                }

                                $pill_link = str_replace("?&", '?', $pill_link);

                                ?>
                                <a class="flex gap-2 px-4 py-1 justify-center items-center no-underline text-brand border-2 hover:shadow-inner border-pale-blue-dark rounded-2xl" href="<?php echo $pill_link; ?>">
                                    <span class="rounded-full shrink-0 w-2 h-2 bg-marketing-<?php echo $taxonomy->taxonomy; ?>"></span>
                                    <span class="text-sm bg-transparent font-regular pill-span">
                                        <?php echo $taxonomy->name; ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>

                    <?php if ($link) : ?>
                    <div class="absolute inset-0 rounded-t-lg z-20">
                        <a
                        class="no-underline absolute inset-0 font-bold text-xl text-brand"
                        href="<?php echo $link; ?>"
                        >
                        <span class="hidden not-sr-only" ><?php echo get_the_title() ;?></span>
                        </a>
                    </div>
                    <?php endif; ?>

            </div>
        </div>
<?php endif; ?>
<?php
}
?>
</div>
</div>
	<div class="pagination relative">
        <?php
			/* example code for using the wp_pagenavi plugin */
			if (function_exists('wp_pagenavi')) {
				$navigation = wp_pagenavi(array( 'query' => $query, 'echo' => false));
                $navigation = str_replace('Next Page', 'next', $navigation);
                $navigation = str_replace('Previous Page', 'previous', $navigation);
                echo $navigation;
			}
		?>
	</div>
	<?php
}
else
{
	echo "No Results Found";
}
?>
