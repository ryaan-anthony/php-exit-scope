<?php
class App
{
    /**
     * @var Scope
     */
    protected $scope;

    /**
     * @var Closure
     */
    protected $application;

    /**
     * @var bool
     */
    protected $hasErrors = false;

    /**
     * Initialize the app
     * @param Closure
     */
    function __construct(Closure $application)
    {
        $this->scope = new Scope($this);

        $this->application = $application;

        register_shutdown_function([$this, 'catchShutdown']);

        set_error_handler([$this, 'catchError']);
    }

    /**
     * Run the app
     */
    public function run()
    {
        $this->_run($this->application) ?
            $this->_success() :
            $this->_fail();
    }

    /**
     * Control flow
     * @param Closure
     * @return bool
     */
    public function _run(Closure $callback)
    {
        try {

            $callback($this->scope);

        } catch (Exception $e) {

            return false;

        }

        return true;
    }

    /**
     * Catch shutdown
     */
    public function catchShutdown()
    {
        $error = error_get_last();

        if ($error) {

            $this->catchError();

        }

    }

    /**
     * Catch errors
     */
    public function catchError()
    {
        if (!$this->hasErrors) {

            $this->hasErrors = true;

            $this->_fail();

        }
    }

    /**
     * App success
     */
    public function _success()
    {
        $this->scope->SUCCESS();
    }

    /**
     * App fail
     */
    public function _fail()
    {
        $this->scope->FAIL();
    }

}
