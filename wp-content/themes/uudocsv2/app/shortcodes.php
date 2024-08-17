<?php

namespace App;

use App\Controllers\App;

/**
 * Return if Shortcodes already exists.
 */
if (class_exists('Shortcodes')) {
    return;
}

/**
 * Shortcodes
 */
class Shortcodes
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $shortcodes = [
            'table',
            'date',
            'month',
            'day',
            'year'
        ];

        return collect($shortcodes)
            ->map(function ($shortcode) {
                return add_shortcode($shortcode, [$this, strtr($shortcode, ['-' => '_'])]);
            });
    }

    /**
     * Box
     * Wraps content in a box.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function table($atts, $content = null)
    {
        $section = [];
        $tables = get_field('sections', get_the_ID());

        if (!isset($atts['id'])) {
            return;
        }

        if ($tables) {
            foreach ($tables as $table) {
                if ($table['table_id'] == $atts['id']) {
                    $section['data']['table'] = $table['table'];

                    break;
                }
            }
        }

        $view = view('partials.content-data-table')->with('section', $section)->render();

        return $view;
    }

    /**
     * Date
     * Returns the current date.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function date($atts, $content = null)
    {
        return date('F d, Y');
    }

    /**
     * Month
     * Returns the current month.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function month($atts, $content = null)
    {
        return date('F');
    }

    /**
    * Day
    * Returns the current day.
    *
    * @param  array  $atts
    * @param  string $content
    * @return string
    */
    public function day($atts, $content = null)
    {
        return date('d');
    }

    /**
     * Year
     * Returns the current year.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function year($atts, $content = null)
    {
        return date('Y');
    }
}

new Shortcodes();
