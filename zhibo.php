<?php
/**
 * Email: john1688@qq.com
 * User: john
 * Date: 2017/10/18
 * Time: 15:35
 */
require 'SDK.php';
class zhibo extends SDK {

    /**
     * ��ȡ������ַ
     * �������key�͹���ʱ�䣬�����ز�����������url
     * @param streamId '����������ͨ������ַ��Ψһid
     *        time ����ʱ�� sample 2016-11-12 12:00:00
     * @return String url
     */
    function getPushUrl($streamId, $time = null)
    {
        if ($time === null) {
            //���û�д���time  Ĭ��2��Сʱ;
            $time = date('Y-m-d H:i:s', time() + 3600 *2);
        }
        $txTime = strtoupper(base_convert(strtotime($time), 10, 16));
        $livecode = $this->BIZID . "_" . $streamId; //ֱ����
        $txSecret = md5($this->PUSH_KEY . $livecode . $txTime);
        $ext_str = "?" . http_build_query(array(
                "bizid" => $this->BIZID,
                "txSecret" => $txSecret,
                "txTime" => $txTime
            ));

        return "rtmp://" . $this->BIZID . ".livepush.myqcloud.com/live/" . $livecode . (isset($ext_str) ? $ext_str : "");
    }

    /**
     * ��ȡ���ŵ�ַ
     * @param streamId '����������ͨ������ַ��Ψһid
     * @return String url
     */
    function getPlayUrl($streamId)
    {
        $livecode = $this->BIZID . "_" . $streamId; //ֱ����
        return array(
            "rtmp://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode,
            "http://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode . ".flv",
            "http://" . $this->BIZID . ".liveplay.myqcloud.com/live/" . $livecode . ".m3u8"
        );
    }

}