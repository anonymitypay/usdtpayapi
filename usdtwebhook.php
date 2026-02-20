<?php
/**
 * 188Pay 回调验证示例 (PHP)
 *
 * 支持两种模式：
 * 1. EPay 模式 - 独角数卡 / V2Board / SSPanel 等系统使用
 * 2. 标准模式 - 自研系统使用标准 JSON 接口
 *
 * 两种模式的签名验证逻辑相同，仅回调参数字段不同。
 */

// ============================================
// 配置：请替换为您的密钥
// ============================================
$secretKey = 'YOUR_SECRET_KEY';

// ============================================
// 接收回调数据
// ============================================
$content = file_get_contents('php://input');
$data = json_decode($content, true);

if (!$data || !isset($data['sign'])) {
    echo 'fail';
    exit;
}

// ============================================
// 验证签名
// ============================================
$receivedSign = $data['sign'];

// 移除不参与签名的字段
unset($data['sign'], $data['sign_type']);

// 移除空值参数
$data = array_filter($data, function ($v) {
    return $v !== '' && $v !== null;
});

// 按参数名 ASCII 码排序
ksort($data);

// 拼接为 key=value& 格式
$str = '';
foreach ($data as $k => $v) {
    $str .= $k . '=' . $v . '&';
}
$str = rtrim($str, '&');

// 追加密钥
$str .= '&secret_key=' . $secretKey;

// MD5 签名
$sign = md5($str);

// 验证
if ($receivedSign === $sign) {
    /**
     * 签名验证通过，处理业务逻辑
     *
     * EPay 模式可用字段：
     *   $data['pid']          - 商户 ID
     *   $data['type']         - 币种类型 (usdt / trx)
     *   $data['out_trade_no'] - 商户订单号
     *   $data['name']         - 订单标题
     *   $data['money']        - 订单金额
     *   $data['status']       - 订单状态 (completed)
     *
     * 标准模式可用字段：
     *   $data['trade_no']      - 系统订单号
     *   $data['out_trade_no']  - 商户订单号
     *   $data['amount']        - 订单金额
     *   $data['actual_amount'] - 实际支付加密货币数量
     *   $data['coin_type']     - 币种类型
     *   $data['status']        - 订单状态 (completed)
     *   $data['tx_hash']       - 区块链交易哈希
     */

    // TODO: 在此处理您的业务逻辑
    // 例如：更新订单状态、发货、开通服务等

    // 返回 success 告知 188Pay 回调已处理
    echo 'success';
} else {
    // 签名验证失败
    echo 'fail';
}
