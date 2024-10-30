<?php
namespace GroundhoggMetacounter;

use function Groundhogg\install_custom_rewrites;
use function Groundhogg\words_to_key;

class Installer extends \Groundhogg\Installer
{

    protected function activate()
    {
        \Groundhogg\Plugin::instance()->dbs->install_dbs();
        Plugin::instance()->roles->install_roles_and_caps();

        // Force optin, you are using premium now.
        \Groundhogg\Plugin::instance()->stats_collection->optin();

        install_custom_rewrites();
    }

    protected function deactivate()
    {
        // TODO: Implement deactivate() method.
    }

    /**
     * The path to the main plugin file
     *
     * @return string
     */
    function get_plugin_file()
    {
        return GROUNDHOGG_METACOUNTER__FILE__;
    }

    /**
     * Get the plugin version
     *
     * @return string
     */
    function get_plugin_version()
    {
        return GROUNDHOGG_METACOUNTER_VERSION;
    }

    /**
     * A unique name for the updater to avoid conflicts
     *
     * @return string
     */
    protected function get_installer_name()
    {
        return words_to_key( GROUNDHOGG_METACOUNTER_NAME );
    }
}