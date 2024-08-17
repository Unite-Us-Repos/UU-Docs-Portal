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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() )
{
	?>

<div class="grid gap-8 lg:grid-cols-3">
	<?php
	$i=1;

	while ($query->have_posts())
	{
		$query->the_post();

		?>
		<?php
		$category = get_the_category(get_the_ID());
		foreach ($category as $cat) {
			$category = $cat->cat_name;
			$catSlug = $cat->category_nicename;
		}
        $link = get_the_permalink();
        $external_link = get_field('external_link');

        $target = '';
        if ($external_link) {
            $link = $external_link;
            $target = ' target="_blank"';
        }
        $img_id = get_post_thumbnail_id(get_the_ID());
        $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);

        $post_type = get_post_type();

        if ($post_type) {
            $type = str_replace('_', ' ', $post_type);
            $type = ucwords($type);
        }
    ?>

<div class="relative group flex flex-col text-left rounded-lg shadow-lg overflow-hidden">
    <div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100 z-10"></div>
        <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
        <div class="flex-1 bg-white flex flex-col justify-between">
            <div class="relative z-30">
                <div class="flex-1 p-8 pt-10">
                <div class="text-sm uppercase font-medium text-action mb-4">
                    <?php echo $type; ?>
                </div>

                <h3 class="mb-4">
                    <?php if ($link): ?>
                        <a
                            class="no-underline font-bold text-xl text-brand group-hover:text-action"
                            href="<?php echo $link; ?>"
                            >
                    <?php endif; ?>
                    <?php the_title(); ?>
                    <?php if ($link): ?>
                        </a>
                    <?php endif; ?>
                </h3>
                <p class="text-xs font-medium text-action mb-4">Updated: <?php the_modified_date(); ?></p>

                <div><?php the_excerpt(); ?></div>

                <div class="absolute inset-0 rounded-t-lg z-20">
                    <a
                        class="no-underline absolute inset-0 font-bold text-xl text-brand"
                        href="<?php echo $link; ?>"
                        >
                        <span class="hidden not-sr-only" ><?php the_title(); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $i++;
}
?>
</div>

<div class="pagination relative">
    <?php
        /* example code for using the wp_pagenavi plugin */
        if (function_exists('wp_pagenavi'))
        {
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
