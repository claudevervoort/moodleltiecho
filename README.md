A do nothing - echo me service to test CRUD operation routing for LTI submodule.

One can use LTI Tools (http://lti.tools/test/tp.php) to deploy a Tool that requires the Echo service.

To get a valid end point URL, just ask for an extra parameter: echo_url=$echo.url and launch the tool.

Service would echo the Body if there is any, and return 204 on Delete.


