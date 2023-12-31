<?php

/**
 * 取款码代付
 */
class WithdrawableCodeDisburse extends \Disburse
{



    /**
     * 电子钱包充值，根据文档描述传参需要
     * @param $disburseAppId    -代付appID
     * @param ...$params
     */
    public function create($disburseAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'businessOrderNo' => rand(1,10000) . '-HasMany-mchOrderNo',
            'amount' => "500000",
            'currency' => 'PHP',
            'userMobile' => '639053005106',
            'appId' => $disburseAppId,
            'options' => [
                'userInfo' => [
                    'birthday' => '',
                    'firstName' => 'Manila',
                    'lastName' => 'Lucky',
                    'address' => '165 Valley View Rd, Hillside, NJ 07205 US',
                    'email' => 'username@gmail.com',
                    'userMobile' => '639053005108',
                ],
                'userAddress' => [
                    'city' => 'New York',
                    'state' => 'New York State',
                    'address' => '165 Valley View Rd, Hillside, NJ 07205 US',
                ],
                'companyInfo' => [
                    'firstName' => 'Hotel',
                    'lastName' => 'Hillside',
                    'address' => '',
                ],
            ],
            'customExtra' => [
                'userId' => 123,
                'othersInfo' => 'xxxx',
            ],
        ];

        return $this->instance->hitEndpoint('/disburse/withdrawal-code/create',$body);
    }

    /**
     * 电子钱包充值，查询订单
     * @param $onFilter
     * @param $onValue
     */
    public function query($onFilter,$onValue){
        $body = compact('onFilter','onValue');

        return $this->instance->hitEndpoint('/disburse/withdrawal-code/get',$body);
    }

    /**
     * 关闭取款码
     * @param $onFilter
     * @param $onValue
     * @return mixed|void
     */
    public function cancel($onFilter, $onValue)
    {
        $body = compact('onFilter','onValue');

        return $this->instance->hitEndpoint('/disburse/withdrawal-code/cancel',$body);
    }

}