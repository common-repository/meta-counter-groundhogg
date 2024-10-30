<?php

namespace GroundhoggMetacounter;

use Groundhogg\DB\Manager;
use Groundhogg\Extension;
use GroundhoggMetacounter\Steps\Actions\Meta_Counter;
use Groundhogg\Admin\Admin_Menu;

class Plugin extends Extension
{
    const DOWNLOAD_ID = 101;

    /**
     * Override the parent instance.
     *
     * @var Plugin
     */
    public static $instance;

    /**
     * Include any files.
     *
     * @return void
     */
    public function includes()
    {
//empty
    }

    /**
     * Init any components that need to be added.
     *
     * @return void
     */
    public function init_components()
    {
        $this->installer = new Installer();
        $this->updater = new Updater();
		$this->roles = new Roles();
    }

    /**
     * Get the ID number for the download in EDD Store
     *
     * @return int
     */
    public function get_download_id()
    {
        return self::DOWNLOAD_ID;
    }
	
    /**
     * register the new benchmark.
     *
     * @param \Groundhogg\Steps\Manager $manager
     */
    public function register_funnel_steps($manager)
    {
        /*ACTIONS*/
        $manager->add_step(new Meta_Counter());
    }

    public function register_admin_pages($admin_menu)
    {
//empty
    }


    /**
     * Get the version #
     *
     * @return mixed
     */
    public function get_version()
    {
        return GROUNDHOGG_METACOUNTER_VERSION;
    }

    /**
     * @return string
     */
    public function get_plugin_file()
    {
        return GROUNDHOGG_METACOUNTER__FILE__;
    }

    /**
     * Register autoloader.
     *
     * Groundhogg autoloader loads all the classes needed to run the plugin.
     *
     * @since 1.6.0
     * @access private
     */
    protected function register_autoloader()
    {
        require dirname(__FILE__) . '/autoloader.php';
        Autoloader::run();
    }


}

Plugin::instance();