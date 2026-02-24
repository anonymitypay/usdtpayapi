简体中文 


# 188pay USDT三方支付API平台 无抽成不压资金，直接支付到自己的USDT地址

<img src="https://www.token188.com/git/git-license.png" height="20px" /></a>
<img src="https://www.token188.com/git/git-build.png" height="20px" /></a>
<img src="https://www.token188.com/git/git-codecov.png" height="20px" /></a>
<img src="https://www.token188.com/git/git-build.png" height="20px" /></a>
- [风铃发卡USDT支付插件tokn188版本下载](https://github.com/utgpay2/card-system-usdtpay)
- [zfaka发卡USDT支付插件tokn188版本下载](https://github.com/utgpay2/zfakausdt)
- [ProxyPanelUSDT支付插件tokn188版本下载](https://github.com/utgpay2/ProxyPanelusdtpay)
- [独角数卡USDT支付插件tokn188版本下载](https://github.com/utgpay2/dujiaokausdtapi)
- [SSPanel USDT支付插件tokn188版本下载](https://github.com/utgpay2/SSPanelusdtapi)
- [V2Board USDT支付插件tokn188版本下载](https://github.com/utgpay2/V2Boardusdtapi)
- [易支付 USDT支付插件tokn188版本](https://github.com/anonymitypay/yipaiusdt-token188)
- [鲸发卡USDT支付插件tokn188版本](https://github.com/anonymitypay/jingfaka)
-
让数字货币支付更简单
188pay商户平台是为有在线收款需求的商家提供的数字货币支付解决方案。在188pay 添加您需要监听的收款地址 然后 在您的网站/App 添加回调地址接受到款通知即可享受安全高效的数字货币收款。使用您自己的USDT地址收款没有中间商，也不用担心跑路

### 特点
 - 使用您自己的USDT地址收款没有中间商
 - 五分钟完成对接
 - 没有任何支付手续费

<p align="center">
<img src="https://www.token188.com/git/token188webhook.png"/>
</p>

### 产品介绍

 - [188pay主页介绍,USDT地址监控API平台](https://www.188pay.net)
 - [188pay钱包](https://www.188pay.net/)（即将推出）
 - [商户平台](https://mar.188pay.net/)

### 支持更多币种
我们随时接纳更多的币种，如果你想让你所支持的币种在数千个商家中能购买商品或服务，欢迎联系我们。


## 支持平台

覆盖各主流电商平台。2分钟内开启数字货币收款。

### Shopify
### WHMCS

<a href="https://github.com/bitpaydev/bitpayxForWHMCS">
<img src="https://dcdn.188pay.com/pay/media/git/whmcs.png" height="50px" style="padding-right: 50px;"/>
</a>

WHMCS是一套国外流行的域名主机管理软件，跟国内众所周知的IDCSystem一样，主要在用户管理、财务管理、域名接口、服务器管理面板接口等方面设计的非常人性化。WHMCS是一套全面支持域名注册管理解析，主机开通管理，VPS开通管理和服务器管理。

### V2Board

<a href="https://github.com/v2board/v2board">
<img src="https://camo.githubusercontent.com/15b835c7ce768a70a7a3c6d9505f895293e92692/68747470733a2f2f757365722d676f6c642d63646e2e786974752e696f2f323031392f31312f31382f313665376631633339623539653532623f773d35303026683d35303026663d706e6726733d3835303535" height="50px" style="padding-right: 50px;"/>
</a>

### SSPanel

<a href="https://github.com/bitpaydev/bitpayx/tree/master/bitpayx">
<img src="https://dcdn.mugglepay.com/pay/media/git/sspanel.png" height="50px" style="padding-right: 50px;"/>
</a>

### 风铃发卡
发卡程序，界面 UI 非常美观，致力于便捷、绿色、安全、快速的销售和购买体验。

### ZFAKA发卡系统  
发卡程序，界面 UI 非常美观，致力于便捷、绿色、安全、快速的销售和购买体验。



## 安装流程
1. 注册[188pay商户中心](https://mar.188pay.com/)
2. 在商户中心添加需要监听的地址
3. 根据使用的不同面板进行回调设置


## 独角数卡接入指南

独角数卡内置易支付（EPay）协议，**无需安装自定义插件**，直接配置即可接入 188pay。

### 配置步骤

**第一步：** 登录 [188pay 商户中心](https://www.188pay.top/dashboard/api-keys)，复制你的 **商户ID（pid）**、**商户密钥（key）** 和 **网关地址**

**第二步：** 登录独角数卡后台 → 左侧菜单 → **配置** → **支付配置** → 找到易支付行点击编辑

**第三步：** 按下表填写配置（只需填 3 个字段）

| 独角字段 | 填写内容 |
|--------|----------|
| 商户 ID | 从 188pay API密钥页面复制 |
| 商户 KEY | `https://api2.188pay.top/submit.php`（网关地址，从 API密钥页面复制） |
| 商户密钥 | 从 188pay API密钥页面复制 |

> 💡 **网关地址说明：** 两个地址都可尝试，不同系统适配不同：
> - `https://api2.188pay.top/submit.php`（直接完整路径，推荐独角使用）
> - `https://api2.188pay.top`（系统会自动拼接 `/submit.php`）
>
> 如均无法使用，请联系 Telegram [@188pay](https://t.me/188pay) 获取支持

**第四步：** 开启启用开关 → 点击「保存」

📖 [查看图文配置教程](./dujiao-epay-tutorial.html)

---

## Q&A 常见问题

**Q：独角数卡有旧版 188pay 自定义插件，还能继续用吗？**

> 旧版插件（`dujiaokausdtapi`）是为老系统私有协议设计的，与新系统字段名不兼容（如 `outTradeNo` vs `merchantOrderId`、`rst` vs `code` 等）。**推荐直接使用独角内置易支付协议**，无需任何插件，配置更简单，系统升级后也不受影响。

**Q：支持哪些币种？**

> 目前支持 **USDT-TRC20** 和 **TRX（波场原生币）**。在接口配置中 type 填 `usdt` 或 `trx`。

**Q：回调是怎么工作的？**

> 链上检测到付款后，188pay 以 GET 方式向独角 `notify_url` 发起回调，携带 `trade_no`、`out_trade_no`、`money`、`trade_status=TRADE_SUCCESS` 等字段及 MD5 签名，独角自动验签并完成订单。

**Q：资金安全吗？**

> 188pay 采用地址监听模式，款项**直接入账到你自己的 USDT 钱包**，平台不托管资金，无跑路风险，0 手续费。

---

## 联系我们
 - telegram：@188pay

## License
[BSD](https://www.wikiwand.com/en/BSD_licenses)
[LICENSE](/LICENSE)
Copyright (c) 2018-present, 188pay Foundation All rights reserved.
