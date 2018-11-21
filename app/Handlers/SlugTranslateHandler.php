<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text)
    {
        $http = new Client;

        /**配置信息 */
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        /**如果没配置，自动使用兼容的拼音方案 */
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        /**根据文档，生成 sign */
        $sign = md5($appid . $text . $salt . $key);

        /**构建请求参数 */
        $query = http_build_query([
            "q" => $text,
            "from" => "zh",
            "to" => "en",
            "appid" => $appid,
            "salt" => $salt,
            "sign" => $sign,
        ]);

        /**发送get请求 */
        $response = $http->get($api . $query);

        $result = json_decode($response->getBody(), true);

        /**获取翻译结果 */
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        } else {
            /**如果失败，使用拼音 */
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}
