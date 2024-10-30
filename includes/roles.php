<?php
namespace GroundhoggMetacounter;

class Roles extends \Groundhogg\Roles
{

    /**
     * Returns an array  of role => [
     *  'role' => '',
     *  'name' => '',
     *  'caps' => []
     * ]
     *
     * In this case caps should just be the meta cap map for other WP related stuff.
     *
     * @return array[]
     */
    public function get_roles()
    {
        return [];
    }
    
	protected function get_admin_cap_check()
    {
        return 'False';
    }
}