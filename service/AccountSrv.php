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
     * @return void
     */
    public function snapBalance(string $before = ''){
        $body = [
            'before' => $before,
        ];

        $result = $this->instance->hitEndpoint('/account/balance',$body);
        print_r($result);
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
     * @return void
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

        $result = $this->instance->hitEndpoint('/account/bills/real-time',$body);
        print_r($result);
    }

    /**
     * 日切账单(Beta)
     * @param $billStartDate
     * @param $billEndDate
     * @return void
     */
    public function dailyBills($billStartDate='',$billEndDate=''){
        $body = compact('billStartDate','billEndDate');

        $result = $this->instance->hitEndpoint('/account/bills/daily',$body);
        print_r($result);
    }
}