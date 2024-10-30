<?php
namespace GroundhoggMetacounter;

use function Groundhogg\words_to_key;

class Updater extends \Groundhogg\Updater
{

    /**
     * A unique name for the updater to avoid conflicts
     *
     * @return string
     */
    protected function get_updater_name()
    {
        return words_to_key( GROUNDHOGG_METACOUNTER_NAME );
    }

    /**
     * Get a list of updates which are available.
     *
     * @return string[]
     */
    protected function get_available_updates()
    {
        return [
            '2.1.6'
        ];
    }

    /**
     * Force stats optin. You are using a premium plugin now, you dont get a choice.
     */
    public function version_2_1_6()
    {
        \Groundhogg\Plugin::instance()->stats_collection->optin();
    }
}