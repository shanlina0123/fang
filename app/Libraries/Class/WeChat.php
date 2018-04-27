<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/12
 * Time: 9:59
 */
use Illuminate\Support\Facades\Cache;
class WeChat
{

    public $appid;
    public $secret;
    public $access_token;
    public $template_id;
    public function __construct()
    {
        $wechatConfig = config('configure.wechat');
        $this->appid = $wechatConfig['appid'];
        $this->secret = $wechatConfig['secret'];
        $this->template_id = $wechatConfig['template_id'];
        $this->url = $wechatConfig['url'];
        $this->access_token = $this->getAccessToken();
    }

    /**
     * @param $openid openid
     * @param $username 用户名
     * @param $phone
     * @param $name 房源名称
     * @param null $url
     * @return bool
     * 发送模板消息
     */
    public function sendNotice( $openid, $username, $phone, $name )
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->access_token;
        $time = date("Y年m月d日");
        $contrnt = '客户'.$username.'在'.$time.'预约了'.$name;
        $data = array(
            'touser'=>$openid,
            'template_id'=>$this->template_id,
            'url'=>$this->url,
            'data'=>array(
                'first'=>['value'=>'客户预约提醒'],
                'keyword1'=>['value'=>$username],//客户姓名
                'keyword2'=>['value'=>$phone],//客户电话
                'keyword3'=>['value'=>$time],
                'keyword4'=>['value'=>$contrnt],
                'remark'=>['value'=>'点击查看详情'],
            )
        );
        $res = $this->curl_request( $url , urldecode(json_encode($data)) );
        if( $res )
        {
            $res = json_decode($res,true);
            if( $res['errcode'] == 0 )
            {
                return true;

            }else
            {
                return false;
            }

        }else
        {
           return false;
        }
    }

    /**
     * @param $openid
     * 获取用户信息
     * ohxBo1o74HVWAXbLR-VzCDXNA8fI
     */
    public function getyWechatUserInfo( $openid )
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$openid.'&lang=zh_CN';
        $data = $this->curl_request( $url );
        if( $data )
        {
            $data = json_decode($data,true);
            if( !array_has($data,'errcode') )
            {
               return $data;

            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }




    /**
     * --------------------------------------------------------------------------------------------
     *   辅助业务
     * --------------------------------------------------------------------------------------------
     */

    /**
     * 获取access_token
     */
    public function getAccessToken()
    {

        if( Cache::has('access_token') )
        {
            $access_token = Cache::get('access_token');
        }else
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret;
            $data = $this->curl_request( $url );
            if( $data )
            {
                $data = json_decode($data,true);
                if( !array_has($data,'errcode') )
                {
                    Cache::put('access_token',$data['access_token'],$data['expires_in']/60);
                    $access_token = $data['access_token'];
                }else
                {
                    $access_token = '';
                }
            }else
            {
                $access_token = '';
            }
        }
        return $access_token;
    }


    /**
     * @param $url
     * @param string $post
     * @param string $cookie
     * @param int $returnCookie
     * @return mixed|string
     * 参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
     */
    public function curl_request($url,$post='',$cookie='', $returnCookie=0)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, uniqid());
        if($post)
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie)
        {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        if (curl_errno($curl))
        {
            return '';
        }
        curl_close($curl);
        if($returnCookie)
        {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else
        {
            return $data;
        }
    }
}