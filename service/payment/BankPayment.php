<?php

/**
 * 银行代收
 */
class BankPayment extends \Payment
{



    /**
     * 创建银行代收的付款链接
     * @param $paymentAppId    -代付appID
     * @param ...$params
     * @return void
     */
    public function create($paymentAppId,...$params){
        $body = [
            'mchOrderNo' => 'YourMerchantOrderNo' . rand(1,1000),
            'minAmount' => "100000",
            'maxAmount' => "100000",
            'currency' => 'PHP',
            'bankCode' => 'GCASH',
            'isSingleUsed' => 1,
            'appId' => $paymentAppId,
            'expireSeconds' => 86400,
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

        $result = $this->instance->hitEndpoint('/payment/bank/create',$body);
        print_r($result);
    }

    /**
     * 银行代收订单查询
     * @param $onFilter
     * @param $onValue
     * @param $page
     * @param $pageSize
     * @param $startTime
     * @param $endTime
     * @return void
     */
    public function query($onFilter,$onValue,$page = 1,$pageSize = 50 , $startTime = '',$endTime = ''){
        $body = compact('onFilter','onValue');

        $result = $this->instance->hitEndpoint('/payment/bank/get',$body);
        print_r($result);
    }

}