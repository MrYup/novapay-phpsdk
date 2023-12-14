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
            $disburse->create($disburseAppId);
            //查询
            $disburse->query('ORDER_NO','231211851062563348422656-PH-PAY');
        },
        'bankTransfer' => function()use($novapay,$disburseAppId){
            //银行转账
            $bankDisburse = new BankDisburse($novapay);
            //创建
            $bankDisburse->create($disburseAppId);
            //查询
            $bankDisburse->query('ORDER_NO','231211851062563348422656-PH-PAY');
        },
        'ewalletTopup' => function()use($novapay,$disburseAppId){
            //电子钱包充值
            $ewalletTopup = new EwalletTopupDisburse($novapay);
            //创建
            $ewalletTopup->create($disburseAppId);
            //查询
            $ewalletTopup->query('ORDER_NO','2312097748885860883636224-PH-PAY');

        },
        'withdrawAbleCode' => function()use($novapay,$disburseAppId){
            //取款码
            $withdrawCode = new WithdrawableCodeDisburse($novapay);
            //创建
            $withdrawCode->create($disburseAppId);
            //查询
            $withdrawCode->query('ORDER_NO','2312093852027448396603392-PH-PAY');
        },
    ],

    'payment' => [
        '' => function()use($novapay,$paymentAppId){
            //通用代收
            $payment= new Payment($novapay);
            //创建
            $payment->create($paymentAppId);
            //查询
            $payment->query('ORDER_NO','231211851062563348422656-PH-PAYIN-BANK');
        },
        'bankPayment' => function()use($novapay,$paymentAppId){
            //银行付款链接
            $bankPayment= new BankPayment($novapay);
            //创建
            $bankPayment->create($paymentAppId);
            //查询
            $bankPayment->query('ORDER_NO','231211851062563348422656-PH-PAYIN-BANK');
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
    ],

    'account' => [
        '' => function()use($account){
            //查看余额
            $account->snapBalance();
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
