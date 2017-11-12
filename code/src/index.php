<?php

use Pukkancs\Rpc\Lib\Collection;
use Pukkancs\Rpc\Lib\Math;
use PayBreak\Rpc\Request;

include_once '../vendor/autoload.php';

class MyApi
{
    use \PayBreak\Rpc\Api;

    protected function getActions()
    {
        return [
            'date' => [self::class, 'date'],
            'flattener' => [self::class, 'flattener'],
            'gcd' => [self::class, 'gcd']
        ];
    }

    protected function authenticate()
    {
        return true;
    }

    protected function getRequestAction()
    {
        return Request::getParam('action');
    }

    protected function getRequestParams()
    {
        return (array)Request::getParam('params');
    }

    protected function date(): array
    {
        $dateTime = new DateTime();

        return [
            'timestamp' => $dateTime->getTimestamp(),
            'today' => $dateTime->format('d/m/Y'),
            'current_month' => $dateTime->format('F'),
            'present' => $dateTime->format(DateTime::RFC2822)
        ];
    }

    protected function flattener(array $params): array
    {
        $subject = json_decode($params['object'],1);

        try {
            return (new Collection($subject))
                ->flatternWithCombinedKeys()
                ->toArray();
        } catch (TypeError $e) {
            return ['error' => 'No array supplied to be flattened.'];
        }
    }

    protected function gcd(array $params) : array
    {
        $array = [(int)$params['a'], (int)$params['b']];

        $subject = new Collection($array);

        $gdc = (new Math())->greatestCommonDivider($subject);

        try {
            return ['gdc' => $gdc];
        } catch (InvalidArgumentException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

$obj = new MyApi();

$obj->executeCall();
