<?php
namespace GroundhoggMetacounter\Steps\Actions;

use function Groundhogg\get_contactdata;
use function Groundhogg\get_db;
use function Groundhogg\html;
use Groundhogg\Contact;
use Groundhogg\Event;
use Groundhogg\Plugin;
use Groundhogg\Step;
use Groundhogg\Steps\Actions\Action;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Meta Counter
 *
 * Adds an action that lets you count any funnel step and stores it in a chosen meta field. 
 *
 * @package     Elements
 * @subpackage  Elements/Actions
 * @author      Pauly Sun <paul@affinitydesign.ca>
 * @copyright   Copyright (c) 2020, Affinity Harmonics Inc.
 * @license     https://opensource.org/licenses/GPL-3.0 GNU Public License v3
 * @since       File available since Release 1.0
 */
class Meta_Counter extends Action
{
    /**
     * @return string
     */
    public function get_help_article()
    {
        return 'https://github.com/Affinity-Harmonics/groundhogg-metacounter';
    }

    /**
     * Get the element name
     *
     * @return string
     */
    public function get_name()
    {
        return _x( 'Meta Counter', 'step_name', 'groundhogg-metacounter' );
    }

    /**
     * Get the element type
     *
     * @return string
     */
    public function get_type()
    {
        return 'Meta_Counter';
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function get_description()
    {
        return _x( 'A counter that saves to selected meta key', 'step_description', 'groundhogg-metacounter' );
    }

    /**
     * Get the icon URL
     *
     * @return string
     */
    public function get_icon()
    {
        return GROUNDHOGG_METACOUNTER_ASSETS_URL . '/images/funnel-icons/meta-counter.png';
    }

    /**
     * Display the settings
     *
     * @param $step Step
     */
    public function settings( $step )
    {
        html()->start_form_table();
        html()->start_row();
        html()->th( __( 'Select Meta Field:', 'groundhogg-metacounter' ) );
        html()->td( [
            html()->dropdown( [
                'name' => $this->setting_name_prefix( 'change_meta_field' ),
                'id' => $this->setting_id_prefix( 'change_meta_field' ),
                'options' => get_db( 'contactmeta' )->get_keys(),
                'selected' => $this->get_setting( 'change_meta_field' ),
                'option_none' => __( 'Please Select a Field', 'groundhogg-metacounter' ),
            ] ),
            html()->description( __( 'Select MetaKey you would like to change', 'groundhogg-metacounter' ) ),
        ] );
        html()->end_row();

        html()->start_row();
        html()->th( __( 'Increment:', 'groundhogg-metacounter' ) );
        html()->td( [
            html()->input( [
                'name' => $this->setting_name_prefix( 'change_increment' ),
                'id' => $this->setting_id_prefix( 'change_increment' ),
                'value' => $this->get_setting( 'change_increment', '' ),

            ] ),
            html()->description( __( 'Ads this value each time triggered', 'groundhogg-metacounter' ) ),

        ] );
        html()->end_row();

        html()->end_form_table();
    }

    public function save( $step )
    {
        $this->save_setting( 'change_meta_field', sanitize_text_field( $this->get_posted_data( 'change_meta_field' ) ) );
        $this->save_setting( 'change_increment', sanitize_text_field( $this->get_posted_data( 'change_increment' ) ) );
    }


    /**
     * Process the http post step...
     *
     * @param $contact Contact
     * @param $event Event
     *
     * @return bool|object
     */
    public function run( $contact, $event )
    {
		$sum = 0;
		$selected_key = $this->get_setting( 'change_meta_field' );
        $selected_increment = $this->get_setting( 'change_increment' );
		absint( $selected_increment );

        $count = absint( $contact->get_meta( ( $selected_key ) ) );
		
		$sum = intval($count) + intval($selected_increment);
		
		$contact->update_meta(( $selected_key ), ( Plugin::$instance->replacements->process( ( $sum ) , $contact->get_id())));

        return true;

    }
}