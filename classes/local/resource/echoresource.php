<?php

namespace ltiservice_echoservice\local\resource;


defined('MOODLE_INTERNAL') || die();

class echoresource extends \mod_lti\local\ltiservice\resource_base {

    public function __construct($service) {

        parent::__construct($service);
        $this->id = 'Echo.item';
        $this->template = '/{context_id}/echo/{echo_id}';
        $this->variables[] = 'echo.url';
        $this->formats[] = 'application/vnd.test.echo+json';
        $this->methods[] = 'GET';
        $this->methods[] = 'PUT';
        $this->methods[] = 'DELETE';
        $this->methods[] = 'POST';
    }

    /**
     * Execute the request for this resource.
     *
     * @param mod_lti\local\ltiservice\response $response  Response object for this request.
     */
    public function execute($response) {
        global $CFG;

        $params = $this->parse_template();
        $contextid = $params['context_id'];
        $echoid = $params['echo_id'];
        if ($response->get_request_method() === 'GET') {
            $contenttype = $response->get_accept();
        } else {
            $contenttype = $response->get_content_type();
        }
        $isdelete = $response->get_request_method() === 'DELETE';
        $results = !empty($contenttype) && ($contenttype === $this->formats[0]);

        try {
            if (!$this->check_tool_proxy(null, $response->get_request_data())) {
                throw new \Exception(null, 401);
            }
            if (empty($contextid) || ($results && ($isdelete)) ||
                (!empty($contenttype) && !in_array($contenttype, $this->formats))) {
                throw new \Exception(null, 400);
            }
            switch ($response->get_request_method()) {
                case 'GET':
                    $echo = new \stdClass();
                    $echo->{"id"}= $echoid;
                    $response->set_code(200);
                    $response->set_body(json_encode($echo));
                    break;
                case 'POST':
                    $response->set_code(201);
                case 'PUT':
                    $response->set_body($response->get_request_data());
                    break;
                case 'DELETE':
                    $response->set_code(204);
                    $response->set_reason('Echo deleted');
                    break;
                default:  // Should not be possible.
                    throw new \Exception(null, 405);
            }

        } catch (\Exception $e) {
            $response->set_code($e->getCode());
        }

    }

    /**
     * Parse a value for custom parameter substitution variables.
     *
     * @param string $value String to be parsed
     *
     * @return string
     */
    public function parse_value($value) {
        global $COURSE, $CFG;

        require_once($CFG->libdir . '/gradelib.php');

        $this->params['context_id'] = $COURSE->id;
        $this->params['echo_id'] = rand(1200, 8900);

        $value = str_replace('$echo.url', parent::get_endpoint(), $value);

        return $value;

    }


}
