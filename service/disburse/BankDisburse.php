<?php

/**
 * 银行转账代付
 */
class BankDisburse extends \Disburse
{



    /**
     * 线上银行转账，根据文档描述传参需要
     * @param $disburseAppId    -代付appID
     * @param ...$params
     * @return array
     */
    public function create($disburseAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,10000000),
            'businessOrderNo' => rand(1,10000) . '-HasMany-mchOrderNo',
            'amount' => "300",
            'currency' => 'PHP',
            'bankCode' => 'RBMI',
            'bankCard' => '09053005108',
            'userName' => 'Manila',
            'userMobile' => '639053005108',
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
            'customExtra' => '',
        ];

        return $this->instance->hitEndpoint('/disburse/bank-transfer/create',$body);
    }

    /**
     * 线上银行转账，查询订单
     * @param $onFilter
     * @param $onValue
     * @return array
     */
    public function query($onFilter,$onValue){
        $body = compact('onFilter','onValue');

        return $this->instance->hitEndpoint('/disburse/bank-transfer/get',$body);
    }

}