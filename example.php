<?php
require_once('src/DataChain.php');

use KLC\DataChain;

class AChain extends DataChain {

    protected function handle(array $params)
    {
        return false;
    }

    protected function terminate(array $params, $result)
    {
        return $result;
    }
}

class BChain extends DataChain {
    protected function handle(array $params)
    {
        return false;
    }

    protected function terminate(array $params, $result)
    {
        return $result;
    }
}

class CChain extends DataChain {
    protected function handle(array $params)
    {
        return $params['hello_world'];
    }
}

$aChain = new AChain();
$bChain = new BChain();
$cChain = new CChain();

$aChain->next($bChain)->next($cChain);

echo $aChain->run(['hello_world' => 'Hello World']);