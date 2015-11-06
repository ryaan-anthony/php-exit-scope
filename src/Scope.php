<?php
class Scope
{
    const STATE_READY = 0;
    const STATE_EXIT = 1;
    const STATE_FAIL = 2;
    const STATE_SUCCESS = 3;

    /**
     * @var Closure[]
     */
    protected $callbacks = [];

    /**
     * Define the scope
     * @param Closure
     * @param int
     */
    public function addCallback(Closure $callback, $state)
    {
        $this->callbacks[$state][] = $callback;
    }

    /**
     * @param int
     * @return array|Closure[]
     */
    public function getCallbacks($state)
    {
        return isset($this->callbacks[$state]) ? $this->callbacks[$state] : [];
    }

    /**
     * Define scope ready
     * @param Closure
     */
    public function onReady(Closure $callback)
    {
        $this->addCallback($callback, self::STATE_READY);
    }

    /**
     * Define scope exit
     * @param Closure
     */
    public function onExit(Closure $callback)
    {
        $this->addCallback($callback, self::STATE_EXIT);
    }

    /**
     * Define scope fail
     * @param Closure
     */
    public function onFail(Closure $callback)
    {
        $this->addCallback($callback, self::STATE_FAIL);
    }

    /**
     * Define scope success
     * @param Closure
     */
    public function onSuccess(Closure $callback)
    {
        $this->addCallback($callback, self::STATE_SUCCESS);
    }

}
