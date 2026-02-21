# 188Pay - 多链加密货币支付网关

> 支持 TRON / Ethereum / BSC / Polygon / Bitcoin / Solana，接受 USDT、ETH、BNB、BTC、SOL 等主流加密货币。资金直达您自己的钱包，无中间商。

[![License](https://img.shields.io/badge/license-BSD-blue.svg)](LICENSE)
[![Platform](https://img.shields.io/badge/platform-188pay.top-brightgreen.svg)](https://www.188pay.top)
[![Telegram](https://img.shields.io/badge/telegram-token188-blue.svg?logo=telegram)](https://t.me/token188)

---

## 特点

- **直接到账** - 收款直达您自己的钱包地址，无资金池，无中间商
- **多链支持** - TRON、Ethereum、BSC、Polygon、Bitcoin、Solana 六大主流公链
- **兼容易支付** - 原生兼容 EPay 协议，独角数卡 / V2Board / SSPanel 等系统可直接对接
- **5 分钟接入** - 注册 → 添加钱包 → 配置回调，三步完成
- **自动汇率** - 支持 CNY / USD / USDT 多币种计价，系统自动换算
- **回调保障** - 支付成功后自动回调，失败自动重试（最多 6 次）

---

## 目录

- [快速开始](#快速开始)
- [支持平台](#支持平台)
- [EPay 接口（推荐）](#epay-接口推荐)
  - [创建订单](#1-创建订单)
  - [回调通知](#2-回调通知)
  - [签名算法](#3-签名算法)
- [标准 JSON 接口](#标准-json-接口)
  - [创建订单](#创建订单)
  - [查询订单](#查询订单)
  - [回调通知](#回调通知)
- [回调验证示例](#回调验证示例)
- [重试策略](#重试策略)
- [常见问题](#常见问题)
- [联系我们](#联系我们)

---

## 快速开始

### 第 1 步：注册商户

前往 [188Pay 商户平台](https://www.188pay.top/login) 注册账号。

### 第 2 步：添加收款钱包

登录后进入 **钱包管理**，添加您的区块链钱包地址：

| 配置项 | 说明 |
|--------|------|
| 区块链网络 | 选择钱包所在链（TRON / Ethereum / BSC 等） |
| 监控币种 | 选择接收的加密货币类型（USDT / ETH / BNB 等） |
| 监控地址 | 您的区块链收款钱包地址，系统将自动监控入账交易 |
| 回调地址 | 支付成功后系统 POST 通知的 URL |
| 系统币种 | 订单计价货币（CNY / USD / USDT） |
| 汇率 | 系统币种与加密货币的兑换比率，如 CNY→USDT 填 `6.38`，留空使用系统默认汇率 |

### 第 3 步：获取 API 密钥

进入 **API 密钥** 页面，获取：

- **商户 ID (pid)** - 用于创建订单时标识身份
- **密钥 (Secret Key)** - 用于签名验证，请妥善保管

### 第 4 步：对接您的系统

根据您的平台选择对接方式：

- **独角数卡 / V2Board / SSPanel 等**：使用 [EPay 接口](#epay-接口推荐)，填入网关地址 + 商户ID + 密钥即可
- **自研系统**：使用 [标准 JSON 接口](#标准-json-接口) 或 [EPay 接口](#epay-接口推荐)

---

## 支持平台

以下平台可通过 EPay 协议直接对接，只需在支付配置中填写：

| 配置项 | 值 |
|--------|------|
| 网关地址 / 商户KEY | 见下方平台说明 |
| 商户 ID | 在 API 密钥页面获取 |
| 密钥 | 在 API 密钥页面获取 |

> **网关地址填写说明：**
> - **独角数卡**：`商户KEY` 字段填写「API 提交地址」，即 `https://你的域名/submit.php`
> - **V2Board / SSPanel**：「网关地址」填写 `https://你的域名`，系统会自动拼接 `/submit.php`

### 兼容的平台列表

| 平台 | 说明 |
|------|------|
| [独角数卡](https://github.com/assimon/dujiaoka) | 自动发卡平台，支付方式选择「易支付」 |
| [V2Board](https://github.com/v2board/v2board) | 机场面板，支付方式选择「易支付」 |
| [SSPanel](https://github.com/Anankke/SSPanel-Uim) | 机场面板，支付方式选择「易支付」 |
| [WHMCS](https://www.whmcs.com/) | 主机域名管理系统 |
| [Shopify](https://www.shopify.com/) | 电商平台 |
| 风铃发卡 | 自动发卡平台 |
| [ZFAKA](https://github.com/zlkbdotnet/zfaka) | 自动发卡平台 |
| 鲸发卡 | 自动发卡平台 |

> 所有支持易支付 (EPay) 协议的系统都可以直接接入。

---

## EPay 接口（推荐）

兼容易支付 (EPay) 标准协议，适用于独角数卡、V2Board、SSPanel 等平台的直接对接。

### 1. 创建订单

**请求地址：** `POST/GET {网关地址}/submit.php`

也可以使用 `{网关地址}/epay/submit` 或 `{网关地址}/epay/submit.php`。

**请求参数：**

| 参数 | 类型 | 必填 | 说明 |
|------|------|------|------|
| `pid` | string | 是 | 商户 ID |
| `type` | string | 是 | 币种类型：`usdt`（默认） / `trx` |
| `out_trade_no` | string | 是 | 商户订单号（您系统中的订单号） |
| `money` | string | 是 | 订单金额（系统币种计价） |
| `notify_url` | string | 是 | 异步回调地址 |
| `return_url` | string | 否 | 支付完成后跳转地址 |
| `name` | string | 否 | 订单标题 |
| `sign` | string | 是 | 签名（见[签名算法](#3-签名算法)） |

**请求示例（HTML 表单）：**

```html
<form action="https://你的域名/submit.php" method="POST">
  <input type="hidden" name="pid" value="YOUR_MERCHANT_ID">
  <input type="hidden" name="type" value="usdt">
  <input type="hidden" name="out_trade_no" value="ORDER_20260220001">
  <input type="hidden" name="money" value="100">
  <input type="hidden" name="notify_url" value="https://你的网站/callback">
  <input type="hidden" name="return_url" value="https://你的网站/return">
  <input type="hidden" name="name" value="商品购买">
  <input type="hidden" name="sign" value="签名值">
  <button type="submit">支付</button>
</form>
```

**成功响应：** 302 跳转到收银台页面。

### 2. 回调通知

支付成功后，系统向 `notify_url` 发送 **POST** 请求（`Content-Type: application/x-www-form-urlencoded`）。

**回调参数：**

| 参数 | 类型 | 说明 |
|------|------|------|
| `pid` | string | 商户 ID |
| `trade_no` | string | 系统订单号 |
| `out_trade_no` | string | 商户订单号 |
| `money` | string | 订单金额 |
| `type` | string | 币种类型 |
| `trade_status` | string | 交易状态（`TRADE_SUCCESS` / `WAIT_BUYER_PAY`） |
| `sign` | string | 签名 |
| `sign_type` | string | 签名类型（`MD5`） |

**回调处理要求：**

1. 验证签名（见[签名算法](#3-签名算法)）
2. 验证通过后处理业务逻辑（发货、开通服务等）
3. 返回 HTTP 200，响应内容为 `success` 或 `ok`
4. **不要**返回 HTML 页面或其他内容，否则系统会认为回调失败并重试

### 3. 签名算法

**EPay 模式签名步骤：**

**第一步：构造签名字符串**

将参与签名的参数按参数名 ASCII 码从小到大排序，拼接为 `key=value&` 格式：

> 注意：`sign` 和 `sign_type` 不参与签名，参数值为空的不参与签名。

```
money=100&notify_url=https://你的网站/callback&out_trade_no=ORDER_001&pid=YOUR_PID&type=usdt
```

**第二步：拼接密钥并 MD5**

在拼接字符串末尾**直接追加**密钥（无任何分隔符），然后 MD5 取小写：

```
sign = MD5("money=100&notify_url=https://你的网站/callback&out_trade_no=ORDER_001&pid=YOUR_PID&type=usdt" + "YOUR_SECRET_KEY")
```

**PHP 签名示例：**

```php
<?php
// EPay 签名生成
function epaySign($params, $secretKey) {
    // 移除 sign 和 sign_type
    unset($params['sign'], $params['sign_type']);

    // 移除空值参数
    $params = array_filter($params, function($v) { return $v !== ''; });

    // 按 ASCII 排序
    ksort($params);

    // 拼接为 key=value& 格式
    $str = urldecode(http_build_query($params));

    // 直接追加密钥（无分隔符）并 MD5
    return md5($str . $secretKey);
}
```

---

## 标准 JSON 接口

适用于自研系统的直接 API 调用。

### 创建订单

**请求地址：** `POST {网关地址}/pay/address`

**Content-Type：** `application/json`

**请求参数：**

| 参数 | 类型 | 必填 | 说明 |
|------|------|------|------|
| `merchantId` | string | 是 | 商户 ID |
| `merchantOrderId` | string | 是 | 商户订单号 |
| `amount` | number | 是 | 订单金额（系统币种计价） |
| `coinType` | string | 否 | 币种：`usdt`（默认） / `trx` |
| `notifyUrl` | string | 否 | 异步回调地址（不填使用钱包配置的地址） |
| `returnUrl` | string | 否 | 支付完成后跳转地址 |
| `subject` | string | 否 | 订单标题 |
| `sign` | string | 是 | 签名 |

**请求示例：**

```bash
curl -X POST https://你的域名/pay/address \
  -H "Content-Type: application/json" \
  -d '{
    "merchantId": "YOUR_MERCHANT_ID",
    "merchantOrderId": "ORDER_20260220001",
    "amount": 100,
    "coinType": "usdt",
    "notifyUrl": "https://你的网站/callback",
    "sign": "签名值"
  }'
```

**成功响应：**

```json
{
  "code": 0,
  "msg": "success",
  "data": {
    "orderId": "20260220143215123456",
    "walletAddress": "TRx1234...abcd",
    "actualAmount": 15.67,
    "expireAt": "2026-02-20T14:52:15.123Z",
    "cashierUrl": "https://你的域名/cashier?id=20260220143215123456"
  }
}
```

| 返回字段 | 说明 |
|----------|------|
| `orderId` | 系统订单号 |
| `walletAddress` | 收款钱包地址 |
| `actualAmount` | 实际需支付的加密货币数量 |
| `expireAt` | 订单过期时间（30 分钟） |
| `cashierUrl` | 收银台页面地址，可直接跳转 |

**错误响应：**

```json
{
  "code": -1,
  "msg": "错误信息"
}
```

**签名算法（标准模式）：**

参与签名的参数：`merchantId`、`merchantOrderId`、`amount`、`coinType`、`notifyUrl`

```
签名字符串 = "amount=100&coinType=usdt&merchantId=YOUR_ID&merchantOrderId=ORDER_001&notifyUrl=https://..."
完整字符串 = 签名字符串 + "&secret_key=YOUR_SECRET_KEY"
sign = MD5(完整字符串).toLowerCase()
```

### 查询订单

**请求地址：** `GET {网关地址}/pay/order/{orderId}`

无需鉴权，公开接口。

**成功响应：**

```json
{
  "code": 0,
  "data": {
    "id": "20260220143215123456",
    "status": "pending",
    "amount": 100,
    "actualAmount": 15.67,
    "coinType": "usdt",
    "walletAddress": "TRx1234...abcd",
    "expireAt": "2026-02-20T14:52:15.123Z",
    "returnUrl": "https://你的网站/return"
  }
}
```

| 状态值 | 说明 |
|--------|------|
| `pending` | 等待支付 |
| `completed` | 支付成功 |
| `expired` | 已超时 |
| `closed` | 已关闭 |

### 回调通知

支付成功后，系统向 `notifyUrl` 发送 **POST** 请求（`Content-Type: application/json`）。

**回调参数：**

| 参数 | 类型 | 说明 |
|------|------|------|
| `trade_no` | string | 系统订单号 |
| `out_trade_no` | string | 商户订单号 |
| `amount` | number | 订单金额 |
| `actual_amount` | number | 实际支付加密货币数量 |
| `coin_type` | string | 币种类型 |
| `status` | string | 订单状态（`completed`） |
| `tx_hash` | string | 区块链交易哈希 |
| `sign` | string | 签名 |
| `sign_type` | string | 签名类型（`MD5`） |

**回调验证签名：**

将回调参数（不含 `sign` 和 `sign_type`）按参数名 ASCII 排序，拼接为 `key=value&` 格式，末尾追加 `&secret_key=你的密钥`，MD5 后与 `sign` 对比。

---

## 回调验证示例

### PHP

```php
<?php
// 接收回调数据
$content = file_get_contents('php://input');
$data = json_decode($content, true);

// 取出签名
$receivedSign = $data['sign'];

// 移除不参与签名的字段
unset($data['sign'], $data['sign_type']);

// 移除空值
$data = array_filter($data, function($v) { return $v !== '' && $v !== null; });

// 按 ASCII 排序
ksort($data);

// 拼接签名字符串
$str = '';
foreach ($data as $k => $v) {
    $str .= $k . '=' . $v . '&';
}
$str = rtrim($str, '&');

// 追加密钥
$str .= '&secret_key=YOUR_SECRET_KEY';

// 验证签名
$sign = md5($str);

if ($receivedSign === $sign) {
    // 签名验证通过
    // TODO: 处理业务逻辑（发货、开通服务等）
    echo 'success';
} else {
    echo 'fail';
}
```

### Node.js

```javascript
const crypto = require('crypto');

function verifyCallback(body, secretKey) {
  const { sign, sign_type, ...params } = body;

  // 按 ASCII 排序，过滤空值
  const sortedStr = Object.keys(params)
    .sort()
    .filter(k => params[k] !== '' && params[k] != null)
    .map(k => `${k}=${params[k]}`)
    .join('&');

  // 追加密钥并 MD5
  const computedSign = crypto
    .createHash('md5')
    .update(sortedStr + '&secret_key=' + secretKey)
    .digest('hex');

  return computedSign === sign;
}

// Express 路由示例
app.post('/callback', (req, res) => {
  if (verifyCallback(req.body, 'YOUR_SECRET_KEY')) {
    // TODO: 处理业务逻辑
    res.send('success');
  } else {
    res.send('fail');
  }
});
```

### Python

```python
import hashlib
import json

def verify_callback(body: dict, secret_key: str) -> bool:
    received_sign = body.pop('sign', '')
    body.pop('sign_type', None)

    # 过滤空值，按 ASCII 排序
    filtered = {k: v for k, v in body.items() if v not in ('', None)}
    sorted_str = '&'.join(f'{k}={filtered[k]}' for k in sorted(filtered))

    # 追加密钥并 MD5
    sign_str = sorted_str + '&secret_key=' + secret_key
    computed_sign = hashlib.md5(sign_str.encode()).hexdigest()

    return computed_sign == received_sign

# Flask 路由示例
@app.route('/callback', methods=['POST'])
def callback():
    data = request.get_json()
    if verify_callback(data.copy(), 'YOUR_SECRET_KEY'):
        # TODO: 处理业务逻辑
        return 'success'
    return 'fail'
```

---

## 重试策略

回调发送失败后，系统按以下间隔自动重试：

| 次数 | 间隔 |
|------|------|
| 第 1 次 | 15 秒后 |
| 第 2 次 | 1 分钟后 |
| 第 3 次 | 5 分钟后 |
| 第 4 次 | 10 分钟后 |
| 第 5 次 | 30 分钟后 |
| 第 6 次 | 60 分钟后 |

共最多重试 6 次。全部失败后可在商户后台手动重发。

---

## 常见问题

### Q: 如何在独角数卡中配置？

在独角数卡后台 → 支付配置 → 添加支付方式 → 选择「易支付」：
- **商户 KEY**（网关地址）：填写 API 密钥页面的「API 提交地址」，即 `https://你的域名/submit.php`
- **商户 ID**：在 188Pay 的 API 密钥页面获取
- **商户密钥**：在 188Pay 的 API 密钥页面获取

> 注意：独角数卡的「商户KEY」字段直接作为表单提交地址，**必须填写带 `/submit.php` 的完整地址**，不能只填根域名。

### Q: 如何在 V2Board 中配置？

在 V2Board 后台 → 支付配置 → 添加支付方式 → 选择「易支付」：
- **网关地址**：填写 API 密钥页面的「EPay 网关地址」，即 `https://你的域名`（V2Board 会自动拼接 `/submit.php`）
- 商户 ID 和密钥同上

### Q: 回调一直失败怎么办？

1. 确认回调地址可以外网访问
2. 确认回调接口返回 `success` 或 `ok`（纯文本，非 HTML 页面）
3. 在商户后台「回调记录」中查看详细的错误信息
4. 使用「测试回调」功能验证回调地址连通性

### Q: 订单金额和实际支付金额不一样？

系统会根据汇率将订单金额（如 CNY）换算为加密货币数量。同时为防止同时段内多笔相同金额的订单混淆，系统会自动在金额上做微调（+0.01 递增）。

### Q: 订单多久过期？

订单创建后 30 分钟内未支付将自动过期。

### Q: 支持哪些区块链？

目前支持 TRON、Ethereum、BSC (BNB Smart Chain)、Polygon、Bitcoin、Solana 六大主流公链。

---

## 联系我们

- 官网：[188pay.top](https://www.188pay.top)
- 商户平台：[www.188pay.top](https://www.188pay.top/login)
- Telegram：[@token188](https://t.me/token188)

---

## License

[BSD](https://www.wikiwand.com/en/BSD_licenses) - Copyright (c) 2018-present, 188Pay Foundation. All rights reserved.
