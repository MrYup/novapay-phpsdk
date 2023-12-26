<?php
/**
 * 模拟接口调用面板
 */
require_once './Novapay.php';
require_once './service/disburse/Disburse.php';
require_once './service/disburse/BankDisburse.php';
require_once './service/disburse/EwalletTopupDisburse.php';
require_once './service/disburse/WithdrawableCodeDisburse.php';

require_once './service/payment/Payment.php';
require_once './service/payment/BankPayment.php';
require_once './service/payment/EWalletPayment.php';
require_once './service/payment/OTCPayment.php';
require_once './service/payment/QRCodePayment.php';
require_once './service/AccountSrv.php';


//代付应用id
$disburseAppId = 1010001007;
//代收应用id
$paymentAppId = 1010001008;

$novapay = Novapay::make();

$account = new AccountSrv($novapay);

//所有网关请求
$handlers = [
    'disburse' => [
        '' => function()use($novapay,$disburseAppId){
            //通用代付
            $disburse = new Disburse($novapay);
            //创建
            $disburseCall = $disburse->create($disburseAppId);
            $disburseResult = json_decode($disburseCall['response'],true);

            echo "\n通用代付：\n";
            print_r(json_encode($disburseResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $disburseResult['data']['orderNo'];
            $disburseQueryCall = $disburse->query('ORDER_NO',$orderNo);
            $disburseQueryResult = json_decode($disburseQueryCall['response'],true);

            echo "\n通用代付查询：\n";
            print_r(json_encode($disburseQueryResult,JSON_PRETTY_PRINT));
        },
        'bankTransfer' => function()use($novapay,$disburseAppId){
            //银行转账
            $bankDisburse = new BankDisburse($novapay);
            //创建
            $disburseCall = $bankDisburse->create($disburseAppId);
            $disburseResult = json_decode($disburseCall['response'],true);

            echo "\n银行转账：\n";
            print_r(json_encode($disburseResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $disburseResult['data']['orderNo'];
            $bankDisburseQueryCall = $bankDisburse->query('ORDER_NO',$orderNo);
            $bankDisburseQueryResult = json_decode($bankDisburseQueryCall['response'],true);

            echo "\n银行转账查询：\n";
            print_r(json_encode($bankDisburseQueryResult,JSON_PRETTY_PRINT));
        },
        'ewalletTopup' => function()use($novapay,$disburseAppId){
            //电子钱包充值
            $ewalletTopup = new EwalletTopupDisburse($novapay);
            //创建
            $disburseCall = $ewalletTopup->create($disburseAppId);
            $disburseResult = json_decode($disburseCall['response'],true);

            echo "\n电子钱包充值：\n";
            print_r(json_encode($disburseResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $disburseResult['data']['orderNo'];
            $disburseQueryCall = $ewalletTopup->query('ORDER_NO',$orderNo);
            $disburseQueryResult = json_decode($disburseQueryCall['response'],true);

            echo "\n电子钱包充值查询：\n";
            print_r(json_encode($disburseQueryResult,JSON_PRETTY_PRINT));

        },
        'withdrawAbleCode' => function()use($novapay,$disburseAppId){
            //取款码
            $withdrawCode = new WithdrawableCodeDisburse($novapay);
            //创建
            $disburseCall = $withdrawCode->create($disburseAppId);
            $disburseResult = json_decode($disburseCall['response'],true);

            echo "\n取款码：\n";
            print_r(json_encode($disburseResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $disburseResult['data']['orderNo'];
            $disburseQueryCall = $withdrawCode->query('ORDER_NO',$orderNo);
            $disburseQueryResult = json_decode($disburseQueryCall['response'],true);

            echo "\n取款码查询：\n";
            print_r(json_encode($disburseQueryResult,JSON_PRETTY_PRINT));

        },
    ],

    'payment' => [
        '' => function()use($novapay,$paymentAppId){
            //通用代收
            $payment= new Payment($novapay);
            //创建
            $paymentCall = $payment->create($paymentAppId);
            $paymentResult = json_decode($paymentCall['response'],true);

            echo "\n通用代收：\n";
            print_r(json_encode($paymentResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $paymentResult['data']['orderNo'];
            $queryCall = $payment->query('ORDER_NO',$orderNo);
            $queryResult = json_decode($queryCall['response'],true);

            echo "\n通用代收查询：\n";
            print_r(json_encode($queryResult,JSON_PRETTY_PRINT));
        },
        'bankPayment' => function()use($novapay,$paymentAppId){
            //银行付款链接
            $bankPayment= new BankPayment($novapay);
            //创建
            $paymentCall = $bankPayment->create($paymentAppId);
            $paymentResult = json_decode($paymentCall['response'],true);

            echo "\n银行付款链接：\n";
            print_r(json_encode($paymentResult,JSON_PRETTY_PRINT));

            //查询
            $orderNo = $paymentResult['data']['orderNo'];
            $queryCall = $bankPayment->query('ORDER_NO',$orderNo);
            $queryResult = json_decode($queryCall['response'],true);

            echo "\n银行付款链接：\n";
            print_r(json_encode($queryResult,JSON_PRETTY_PRINT));
        },
        'ewalletPayment' => function()use($novapay,$paymentAppId){
            //电子钱包付款链接
            $ewalletPayment = new EWalletPayment($novapay);
            //创建
            $ewalletPayment->create($paymentAppId);
            //查询
            $ewalletPayment->query('ORDER_NO','2312097748885860883636224-PH-PAYIN-EW');
        },
        'otcPayment' => function()use($novapay,$paymentAppId){
            //便利店付款码
            $OTCPayment = new OTCPayment($novapay);
            //创建
            $OTCPayment->create($paymentAppId);
            //查询
            $OTCPayment->query('ORDER_NO','2312093852027448396603392-PH-PAYIN-OTC');
        },
        'qrcodePayment' => function()use($novapay,$paymentAppId){
            //二维码付款
            $qrcodePayment = new QRCodePayment($novapay);
            //创建
            $qrcodePayment->create($paymentAppId);
            //查询
            $qrcodePayment->query('ORDER_NO','2312093852027448396603392-PH-PAYIN-QR');
        },
        'bankCodeList' => function()use($novapay,$paymentAppId){
            $payment= new Payment($novapay);
            //创建
            $paymentCall = $payment->bankCodeList($paymentAppId);
            $paymentResult = json_decode($paymentCall['response'],true);

            echo "\n通用代收：\n";
            print_r(json_encode($paymentResult,JSON_PRETTY_PRINT));
        },
    ],

    'account' => [
        '' => function()use($account){
            //查看余额
            $endpointCall = $account->snapBalance();

            //创建
            $accountResult = json_decode($endpointCall['response'],true);
            print_r(json_encode($accountResult,JSON_PRETTY_PRINT));
        },
        'realTimeBills' => function()use($account){
            //实时拉取账单
            $account->realTimeBills();
        },
        'dailyBills' => function()use($account){
            //拉取日切账单
            $account->dailyBills();
        },
    ],
];


$module = $argv[1]??'';
$subModule = $argv[2]??'';

$func = $handlers[$module][$subModule]??null;

if (!$module){
    echo "\033[0m\033[33m Module required \033[0m";
    echo "\n";
    die(0);
}

if (!$func instanceof Closure){
    echo "\033[0m\033[33m Handlers.$module.$subModule undefined \033[0m";
    echo "\n";
    die(0);
}

$func();
