<?php

namespace KLC;

abstract class DataChain
{
    /** @var $next DataChain */
    protected $next;

    /** @var $preview DataChain */
    protected $preview;

    /**
     * @param array $params
     * @return mixed
     */
    abstract protected function handle(array $params);

    /**
     * @param array $params
     * @param mixed $result
     * @return mixed
     */
    protected function terminate(array $params, $result)
    {
        return false;
    }

    /**
     * @param DataChain $chain
     * @return DataChain
     */
    public function next(DataChain $chain)
    {
        $this->next = $chain;
        $chain->preview = $this;

        return $chain;
    }

    /**
     * @param array $params
     * @return false|mixed|void
     */
    public function run(array $params = [])
    {
        $result = $this->handle($params);

        if ($result !== false) {
            if ($this->preview) {

                return $this->preview->handleRecover($params, $result);
            }

            return $result;
        }

        if ($this->next) {

            return $this->next->run($params);
        }
    }

    /**
     * @param $params
     * @param $result
     * @return false|mixed
     */
    protected function handleRecover($params, $result)
    {
        $result = $this->terminate($params, $result);

        if ($result !== false && $this->preview) {

            return $this->preview->handleRecover($params, $result);
        }

        return $result;
    }

}