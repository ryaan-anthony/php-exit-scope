<?php
class Scope
{
    const SCOPE_EXIT = 1;
    const SCOPE_FAIL = 2;
    const SCOPE_SUCCESS = 3;

    /**
     * @var Closure[]
     */
    protected $callbacks = [];

    /**
     * @var App
     */
    protected $app;

    /**
     * Initialize the scope
     * @param App
     */
    function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Define the scope
     * @param Closure
     * @param $scope
     */
    public function setScope(Closure $callback, $scope)
    {
        $this->callbacks[$scope][] = $callback;
    }

    /**
     * @param int
     * @return array|Closure[]
     */
    protected function getScope($scope)
    {
        return isset($this->callbacks[$scope]) ? $this->callbacks[$scope] : [];
    }

    /**
     * Define scope exit
     * @param Closure
     */
    public function onExit(Closure $callback)
    {
        $this->setScope($callback, self::SCOPE_EXIT);
    }

    /**
     * Define scope fail
     * @param Closure
     */
    public function onFail(Closure $callback)
    {
        $this->setScope($callback, self::SCOPE_FAIL);
    }

    /**
     * Define scope success
     * @param Closure
     */
    public function onSuccess(Closure $callback)
    {
        $this->setScope($callback, self::SCOPE_SUCCESS);
    }

    /**
     * Run scope success
     * @param Closure
     */
    public function SUCCESS()
    {
        $this->EXECUTE($this->getScope(self::SCOPE_SUCCESS));
        $this->END();
    }

    /**
     * Run scope fail
     * @param Closure
     */
    public function FAIL()
    {
        $this->EXECUTE($this->getScope(self::SCOPE_FAIL));
        $this->END();
    }

    /**
     * Run scope exit
     * @param Closure
     */
    public function END()
    {
        $this->EXECUTE($this->getScope(self::SCOPE_EXIT));
        exit;
    }

    /**
     * @param Closure[]
     */
    protected function EXECUTE(array $callbacks = [])
    {
        foreach ($callbacks as $callback) {

            $this->app->_run($callback);

        }
    }

}
