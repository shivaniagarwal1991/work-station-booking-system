<?php

namespace App\Trait;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait BookingTrait
{

    protected function hasVaildParams(array $params)
    {
        $vaildArr = [];
        if (count($params)) {
            $vaildArr['status'] = 1;
            if (empty($params['work_station_id']) || empty($params['user_hash']) || empty($params['date']) || empty($params['start_time']) || empty($params['end_time'])) {
                $this->throwError();
            }
            $params['date'] = date("d-m-Y", strtotime($params['date']));
            $this->isValidEmail($params['user_hash']);
            $this->isVaildTimeFormat($params['start_time'], $params['date']);
            $this->isVaildTimeFormat($params['end_time'], $params['date']);

            $this->isValidDate($params['date']);
            $this->isValidDay($params['date']);

            if ($params['end_time'] < $params['start_time']) {
                $this->throwError('invalidstartendtime');
            }

            $vaildArr['work_station_id'] = $params['work_station_id'];
            $vaildArr['user_hash'] = $params['user_hash'];
            $vaildArr['date'] = $params['date'];
            $vaildArr['start_time'] = str_replace(':', '', $params['start_time']);
            $vaildArr['end_time'] = str_replace(':', '', $params['end_time']);
            return $vaildArr;
        }
        $this->throwError();
    }


    private function isValidEmail($email)
    {
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL)
            && preg_match('/@.+\./', $email))) {
            $this->throwError('inValidEmail');
        }
    }

    private function isVaildTimeFormat($time, $requestedDate)
    {
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            $firstValue = explode(':', $time)[0];
            if (!(preg_match("/([0][9-9]|1[0-7]):([0-0][0-0])/", $time))) {
                $this->throwError('inVaildTimeFormat');
            }
            $currentDate = date("d-m-Y");
            if (strtotime($currentDate) == strtotime($requestedDate) && (date('H') > $firstValue)) {
                $this->throwError('invalidstarttime');
            }
            return true;
        }
        $this->throwError('inVaildTimeFormat');
    }



    private function isValidDate($date)
    {
        $date_now = date("d-m-Y");
        //No past date
        if (strtotime($date_now) > strtotime($date)) {
            $this->throwError('invaliddate');
        }
        if (strtotime($date) > strtotime($date_now . ' + 5 days')) {
            $this->throwError('invaliddate');
        }
    }

    private function isValidDay($date)
    {
        $dayName = date('D', strtotime($date));
        if ($dayName == 'Sat' || $dayName == 'Sun') {
            $this->throwError('invalidday');
        }
    }

    private function throwError($type = null)
    {
        throw new NotFoundHttpException($this->errorMessage($type));
    }

    private function errorMessage($type = null)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'invalidemail':
                return 'Expecting Vaild email id in user_hash';
            case 'invaildtimeformat':
                return 'Expecting Vaild start_time and end_time in HH:SS from 09:00 to 17:00';
            case 'invaliddate':
                return 'Expecting today or next 5 future date(dd-mm-yyyy) only.';
            case 'invalidday':
                return 'Expecting booking only from Mon to Fri.';
            case 'invalidstartendtime':
                return 'Expecting Vaild end_time must be greater than start_time';
            case 'invalidstarttime':
                return 'Expecting Vaild start_time must be greater than current time';
            default:
                return "Expecting mandatory parameters like work_station_id, user_hash, date(DD-MM-YYYY), start_time(00:00), end_time(00:00)";
        }
    }
}
