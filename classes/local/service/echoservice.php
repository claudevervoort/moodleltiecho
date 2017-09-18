<?php

namespace ltiservice_echoservice\local\service;

use ltiservice_echoservice\local\resource\echoresource;

defined('MOODLE_INTERNAL') || die();

/**
 * A service for testing the service subsystem - just doing an echo of the request
 *
 * @package    ltiservice_echo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class echoservice extends \mod_lti\local\ltiservice\service_base {

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'echoservice';
        $this->name = get_string('servicename', 'ltiservice_echoservice');
        $this->unsigned = true;

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        if (empty($this->resources)) {
            $this->resources = array();
            $this->resources[] = new echoresource($this);
        }

        return $this->resources;

    }

}
