<?php

namespace App\Trait;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait WorkStationTrait
{
    protected function hasVaildParams(array $params)
    {
        $vaildArr = [];
        if (count($params)) {
            $vaildArr['status'] = 1;
            if (!empty($params['status'])) {
                $vaildArr['status'] = ($params['status'] == 0) ? 0 : 1;
            }
            if (empty($params['name']) || empty($params['type'])) {
                throw new NotFoundHttpException('Expecting mandatory parameters like name, type');
            }
            $vaildArr['name'] = $params['name'];
            $vaildArr['type'] = ($params['type'] == 'meeting') ? $params['type'] : (($params['type'] == 'desk') ? $params['type'] : 'meeting');
            return $vaildArr;
        }
        throw new NotFoundHttpException('Expecting mandatory parameters like name, type, status!');
    }
}
