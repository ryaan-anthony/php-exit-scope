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
        $this->scope = new Scope();

        $this->application = $application;

        register_shutdown_function([$this, 'catchShutdown']);

        set_error_handler([$this, 'catchError']);
    }

    /**
     * Run the app
     */
    public function run()
    {
        $isCompiled = $this->executeCallback($this->application);
        
        if ($isCompiled) {

            $this->changeState(Scope::STATE_READY);
            
            $this->changeState(Scope::STATE_SUCCESS);
                        
        } else {

            $this->changeState(Scope::STATE_FAIL);
            
        }

        $this->changeState(Scope::STATE_EXIT);
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

            $this->changeState(Scope::STATE_FAIL);

            $this->changeState(Scope::STATE_EXIT);

            exit;

        }
    }

    protected function changeState($state)
    {
        $callbacks = $this->scope->getCallbacks($state);

        foreach ($callbacks as $callback) {

            $this->executeCallback($callback);

        }

    }

    /**
     * Control flow
     * @param Closure
     * @return bool
     */
    protected function executeCallback(Closure $callback)
    {
        try {

            $callback($this->scope);

        } catch (Exception $e) {

            return false;

        }

        return true;
    }

}
