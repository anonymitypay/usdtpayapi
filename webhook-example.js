/**
 * 188Pay  回调验证示例 (Node.js / Express)
 *
 * 支持 EPay 模式和标准模式，签名验证逻辑相同。
 *
 * 安装依赖：npm install express
 * 运行：node webhook-example.js
 */

const crypto = require('crypto');
const express = require('express');

const app = express();
app.use(express.json());

// 配置：请替换为您的密钥
const SECRET_KEY = 'YOUR_SECRET_KEY';

/**
 * 验证回调签名
 */
function verifySign(body, secretKey) {
  const { sign, sign_type, ...params } = body;

  // 过滤空值，按 ASCII 排序，拼接为 key=value& 格式
  const sortedStr = Object.keys(params)
    .sort()
    .filter((k) => params[k] !== '' && params[k] != null)
    .map((k) => `${k}=${params[k]}`)
    .join('&');

  // 追加密钥并 MD5
  const computedSign = crypto
    .createHash('md5')
    .update(sortedStr + '&secret_key=' + secretKey)
    .digest('hex');

  return computedSign === sign;
}

/**
 * 回调接收接口
 */
app.post('/callback', (req, res) => {
  const data = req.body;

  if (!data || !data.sign) {
    return res.send('fail');
  }

  if (verifySign(data, SECRET_KEY)) {
    // 签名验证通过

    // EPay 模式字段：pid, type, out_trade_no, name, money, status
    // 标准模式字段：trade_no, out_trade_no, amount, actual_amount, coin_type, status, tx_hash

    console.log('回调验证通过:', data.out_trade_no);

    // TODO: 在此处理您的业务逻辑
    // 例如：更新订单状态、发货、开通服务等

    res.send('success');
  } else {
    console.log('签名验证失败');
    res.send('fail');
  }
});

app.listen(3000, () => {
  console.log('回调接收服务运行在 http://localhost:3000');
});
