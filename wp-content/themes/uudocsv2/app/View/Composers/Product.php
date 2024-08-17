<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Product extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.product-*',
        'sections.sidebar',
        'partials.content-front-page',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title'                     => $this->title(),
            'latest_release_notes'     => $this->latestReleaseNotes(),
            'related_release_notes'     => $this->relatedReleaseNotes(),
            'guide_sections'            => $this->guideSections(),
            'guides_by_sections'        => $this->guidesBySection(),
            'release_note_taxonomies'   => $this->releaseNoteTaxonomies(),
            'guides_side_navigation'    => $this->guidesSideNavigation(),
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        return single_term_title('', false);
    }

    /**
     * Returns latest release notes.
     *
     * @return string
     */
    public function latestReleaseNotes()
    {
        $args = [
            'posts_per_page'    => 4,
            'tax_query'         => '',
        ];

        return $this->getReleaseNotes($args);
    }

    /**
     * Returns related release notes.
     *
     * @return string
     */
    public function relatedReleaseNotes()
    {
        $args = [
            'posts_per_page' => 3,
        ];

        return $this->getReleaseNotes($args);
    }

    /**
     * Returns guides ordered by guide section.
     *
     * @return string
     */
    public function guidesBySection()
    {
        $sectionGuides  = [];
        $product_slug   = [];
        $term = get_queried_object();

        if ($term) {
            $product_slug = $term->slug;
        }
        $guide_sections = $this->guideSections();

        foreach ($guide_sections as $section) {
            $section_slug  = $section->slug;
            $section_order = $section->term_order;

            $args = [
                'posts_per_page'    => -1,
                'tax_query'         => [
                    'relation'      => 'AND',
                    [
                        'taxonomy'  => 'product',
                        'field'     => 'slug',
                        'terms'     => $product_slug,
                    ],
                    [
                        'taxonomy'  => 'guide_section',
                        'field'     => 'slug',
                        'terms'     => $section_slug,
                    ],
                ],
            ];

            $sectionGuides[$section_order]['term_id']       = $section->term_id;
            $sectionGuides[$section_order]['slug']          = $section->slug;
            $sectionGuides[$section_order]['title']         = $section->name;
            $sectionGuides[$section_order]['description']   = $section->description;
            $sectionGuides[$section_order]['posts']         = $this->getProductGuides($args);
        }

        return $sectionGuides;
    }

    /**
     * Returns guides ordered by guide section.
     *
     * @return string
     */
    public function guidesSideNavigation()
    {
        $sectionGuides = [];
        $products = $this->getTerms('product');

        foreach ($products as $index => $term) {
            $product_slug = $term->slug;
            $guide_sections = $this->guideSections();

            foreach ($guide_sections as $index => $section) {
                $is_active          = 0;
                $is_active_guide    = 0;
                $guide_posts        = [];
                $section_slug       = $section->slug;
                $section_order      = $section->term_order;
                $guide_product_slug = '';

                if (is_singular('guide')) {
                    $guide_terms = get_the_terms(get_the_ID(), 'product');

                    if (isset($guide_terms[0])) {
                        $guide_product_slug = $guide_terms[0]->slug;

                        if ($guide_product_slug == $term->slug) {
                            $args = [
                                'posts_per_page'    => -1,
                                'tax_query'         => [
                                    'relation'      => 'AND',
                                    [
                                        'taxonomy'  => 'product',
                                        'field'     => 'slug',
                                        'terms'     => $guide_product_slug,
                                    ],
                                    [
                                        'taxonomy'  => 'guide_section',
                                        'field'     => 'slug',
                                        'terms'     => $section_slug,
                                    ],
                                ],
                            ];

                            $guide_posts    = $this->getProductGuides($args);

                            $is_active      = 1;
                        }
                    }
                }

                if (is_tax('product')) {
                    $cur_term = get_queried_object()->slug;
                    if ($cur_term == $product_slug) {
                        $is_active_guide = 1;
                    }
                }
                $sectionGuides[$term->term_id]['nav_item']['term_id']                      = $term->term_id;
                $sectionGuides[$term->term_id]['nav_item']['is_active_guide']              = $is_active_guide;
                $sectionGuides[$term->term_id]['nav_item']['is_active']                    = $is_active;
                $sectionGuides[$term->term_id]['nav_item']['name']                         = $term->name;
                $sectionGuides[$term->term_id]['nav_item']['description']                  = $term->description;
                $sectionGuides[$term->term_id]['nav_item']['link']                         = '/' . $term->taxonomy . '/' . $term->slug . '/';
                $sectionGuides[$term->term_id]['sections'][$section_order]['term_id']      = $section->term_id;
                $sectionGuides[$term->term_id]['sections'][$section_order]['title']        = $section->name;
                $sectionGuides[$term->term_id]['sections'][$section_order]['description']  = $section->description;
                $sectionGuides[$term->term_id]['sections'][$section_order]['posts']        = $guide_posts;

                // append custom fields
                $custom_fields = get_field('product', $term->taxonomy . '_' . $term->term_id);

                if ($custom_fields) {
                    foreach ($custom_fields as $name => $field) {
                        $sectionGuides[$term->term_id]['nav_item'][$name]    = $custom_fields[$name];
                    }
                }
            }
        }
        ksort($sectionGuides);
        return $sectionGuides;
    }

    public static function getReleaseNotes($args)
    {
        $current_id = get_the_ID();
        $slug = '';
        $product_slug = '';

        $term = get_queried_object();

        if ($term) {
            $product_slug = $term->slug;
        }

        $defaults = [
            'post_type'         => 'release_note',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'tax_query'         => [
                [
                    'taxonomy'  => 'product',
                    'field'     => 'slug',
                    'terms'     => $product_slug,
                ],
            ],
        ];

        $postItems = [];
        $index = 0;

        $args = wp_parse_args($args, $defaults);

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$index]['ID']                = get_the_ID();
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id                                 = get_post_thumbnail_id(get_the_ID());
                $alt_text                               = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['slug']              = $slug;
                $postItems[$index]['excerpt']           = get_the_excerpt();
                $postItems[$index]['date']              = get_the_date();
                $postItems[$index]['modified_date']     = get_the_modified_date();
                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public function getProductGuides($args, $guide_product_slug='')
    {
        $current_id = get_the_ID();
        $slug       = '';

        if ($guide_product_slug) {
            $slug = $guide_product_slug;
        } else {
            $term = get_queried_object();
            if ($term) {
                $slug = $term->slug;
            }
        }

        $defaults = [
            'post_type'         => 'guide',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'tax_query'         => [
                [
                    'taxonomy'  => 'product',
                    'field'     => 'slug',
                    'terms'     => $slug,
                ],
            ],
        ];

        $postItems = [];
        $index = 0;

        $args = wp_parse_args($args, $defaults);

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $is_active = '0';
                if (get_the_ID() == $current_id) {
                    $is_active = '1';
                }
                $slug = get_post_field('post_name', get_post());
                $excerpt = get_the_excerpt();
                $excerpt = str_replace('Overview', '', $excerpt);

                $postItems[$index]['ID']                = get_the_ID();
                $postItems[$index]['is_active']         = $is_active;
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['slug']              = $slug;
                $postItems[$index]['excerpt']           = $excerpt;
                $postItems[$index]['date']              = get_the_date();
                $postItems[$index]['modified_date']     = get_the_modified_date();
                $postItems[$index]['acf']               = $this->fetchAcfData(get_the_ID());

                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public function getTerms($taxonomy='')
    {
        $args = [
            'taxonomy'  => $taxonomy,
        ];

        $taxonomies = get_terms($args);

        return $taxonomies;
    }

    public function guideSections()
    {
        $taxonomies = $this->getTerms('guide_section');

        return $taxonomies;
    }

    public function releaseNoteTaxonomies($post_id='')
    {
        $taxonomies = [];
        $new_taxonomies = [];
        $custom_taxonomies = ['product', 'feature', 'user'];

        foreach ($custom_taxonomies as $taxonomy) {
            $taxonomies[] = get_the_terms($post_id, $taxonomy);
        }

        foreach ($taxonomies as $index => $taxonomy) {
            if ($taxonomy) {
                foreach ($taxonomy as $t_index => $tax) {
                    $taxonomies[$index][$t_index]->taxonomy_color_class = $this->getTaxColor($tax->taxonomy);
                }
            }
        }

        return $taxonomies;
    }

    private function getTaxColor($tax='')
    {
        $color_map = [
            'product' => 'marketing-product',
            'feature' => 'marketing-feature',
            'user'    => 'marketing-user',
        ];

        return $color_map[$tax];
    }

    private function fetchAcfData($post_id = '')
    {
        $fields = get_fields($post_id);

        return $fields;
    }

}

