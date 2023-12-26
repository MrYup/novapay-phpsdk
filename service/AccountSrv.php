<?php

class AccountSrv
{
    /**
     * @var \Novapay
     */
    protected $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }


    /**
     * 指定时间点的账户余额信息
     * @param string $before
     */
    public function snapBalance(string $before = ''){
        $body = [
            'before' => $before,
        ];

        return $this->instance->hitEndpoint('/account/balance',$body);
    }

    /**
     * 实时账单
     * @param $orderType
     * @param $onFilter
     * @param $onValue
     * @param $page
     * @param $pageSize
     * @param $startTime
     * @param $endTime
     */
    public function realTimeBills($orderType=''
        ,$onFilter=''
        ,$onValue=''
        ,$page=1
        ,$pageSize = 50
        ,$startTime = ''
        ,$endTime = ''
    ){
        $body = compact('orderType','onFilter','onValue','page','pageSize','startTime','endTime');

        return $this->instance->hitEndpoint('/account/bills/real-time',$body);
    }

    /**
     * 日切账单(Beta)
     * @param $billStartDate
     * @param $billEndDate
     */
    public function dailyBills($billStartDate='',$billEndDate=''){
        $body = compact('billStartDate','billEndDate');

        return $this->instance->hitEndpoint('/account/bills/daily',$body);
    }
}