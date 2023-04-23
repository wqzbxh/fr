<?php
/**
 * Created by : PhpStorm
 * User: 哑巴湖大水怪（王海洋）
 * Date: 2023/4/23
 * Time: 22:31
 */

namespace libs\core\Jwt;

use libs\core\Config;
use Matrix\Exception;

class JWT
{


    private static $algos = array(
        'HS256' => 'sha256',
        'HS384' => 'sha384',
        'HS512' => 'sha512',
        'RS256' => 'sha256',
        'RS384' => 'sha384',
        'RS512' => 'sha512'
    );

    private static function base64UrlEncode($data)
    {
        $urlSafeData = strtr(base64_encode($data), '+/', '-_');
        return rtrim($urlSafeData, '=');
    }

    private static function base64UrlDecode($data)
    {
        $urlUnsafeData = strtr($data, '-_', '+/');
        $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($paddedData);
    }

    public static function encode($payload, $key, $algo = 'HS256')
    {
        $header = array(
            'typ' => 'JWT',
            'alg' => $algo
        );

        $headerJson = json_encode($header);
        $payloadJson = json_encode($payload);

        $headerBase64Url = self::base64UrlEncode($headerJson);
        $payloadBase64Url = self::base64UrlEncode($payloadJson);

        $signature = hash_hmac(self::$algos[$algo], $headerBase64Url . '.' . $payloadBase64Url, $key, true);
        $signatureBase64Url = self::base64UrlEncode($signature);

        return $headerBase64Url . '.' . $payloadBase64Url . '.' . $signatureBase64Url;
    }

    /**
     * @return mixed
     * $jwt：要解码的 JWT 字符串
     *$key：用于解码 JWT 的密钥
     *$verify：一个布尔标志，指示是否验证 JWT 签名。默认值为 true。
     */
    public static function decode($jwt, $key, $verify = true)
    {
        $parts = explode('.', $jwt);

        if (count($parts) != 3) {
            return  false;
        }

        $headerBase64Url = $parts[0];
        $payloadBase64Url = $parts[1];
        $signatureBase64Url = $parts[2];

        $headerJson = self::base64UrlDecode($headerBase64Url);
        $header = json_decode($headerJson, true);

        if (!isset(self::$algos[$header['alg']])) {
            return  false;
        }

        $signature = self::base64UrlDecode($signatureBase64Url);
        $expectedSignature = hash_hmac(self::$algos[$header['alg']], $headerBase64Url . '.' . $payloadBase64Url, $key, true);

        if ($verify && !hash_equals($signature, $expectedSignature)) {
             return  false;
        }

        $payloadJson = self::base64UrlDecode($payloadBase64Url);
        $payload = json_decode($payloadJson, true);

        return $payload;
    }
}
