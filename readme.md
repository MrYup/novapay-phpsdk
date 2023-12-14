
## 目录结构

- service/disburse, 各种代付产品demo，包括银行转账，电子钱包充值，取款码
- service/payment, 各种代收产品demo，包括银行付款链接，电子钱包付款链接，便利店付款码，二维码付款
- config.php, 配置文件
- Novapay.php，demo运行依赖
- testPanel.php，demo运行入口

## 测试用例


#### 代付测试

- 通用代付测试

```shell
php testPanel.php disburse
```

- 银行代付测试

```shell
php testPanel.php disburse bankTransfer
```

- 电子钱包代付测试

```shell
php testPanel.php disburse ewalletTopup
```

- 取款码代付测试

```shell
php testPanel.php disburse withdrawAbleCode
```



#### 代收测试

- 通用代收测试

```shell
php testPanel.php payment
```

- 银行代收测试

```shell
php testPanel.php payment bankPayment
```

- 电子钱包代收测试

```shell
php testPanel.php payment ewalletPayment
```

- 收款码代收测试

```shell
php testPanel.php payment otcPayment
```


- 二维码代收测试

```shell
php testPanel.php payment qrcodePayment
```


#### 账号信息测试

- 查看余额

```shell
php testPanel.php account
```

- 实时拉取账单

```shell
php testPanel.php account realTimeBills
```

- 拉取日切账单

```shell
php testPanel.php account dailyBills
```