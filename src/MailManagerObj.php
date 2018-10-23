<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-15
 * Time: 오전 11:38
 */

namespace Luna\MailManager;

use Luna\MailManager\Commons\CommonConst as CODE;
use Luna\MailManager\Objects\Domains\Google\MailServiceGoogleObj;
use Luna\MailManager\Objects\Tables\TMailAccountManagerLogObj;
use Luna\MailManager\Objects\Tables\TMailSendLogObj;

class MailManagerObj
{
    private $mail_service;

    public function __construct()
    {
        $this->mail_service = new MailServiceGoogleObj;
    }

    /**메일발송 및 이력 저장
     * @param $req_param
     * @return string
     */
    public function sendMailMessage($req_param)
    {
        //파라미터처리
        $mail_message = $this->mail_service->convertReqToMailFormat($req_param);
        //메일전송
        $proc_rtn = $this->mail_service->sendMail($mail_message);
        //결과처리
        $req_param = $this->resultAddReqParam($proc_rtn, $req_param);
        //메일전송이력 저장
        $this->insertMailSendLog($req_param);

        return CODE::RETURN_SUCCEED;
    }

    /**메일발송 이력 조회
     * @param $req_param
     * @return array
     */
    public function searchMailSendLog($req_param)
    {
        //메일전송이력 조회
        $mail_send_log_obj = new TMailSendLogObj();
        $result = $mail_send_log_obj->load($req_param);

        return[
            'data' => $result
        ];

    }

    /**계정생성 및 이력 저장
     * @param $req_param
     * @return string
     */
    public function createUserAccount($req_param)
    {
        //파라미터처리
        $user_info = $this->mail_service->convertReqToAccountFormat($req_param);
        //계정생성
        $proc_rtn = $this->mail_service->createUserAccount($user_info);
        //결과처리
        $req_param = $this->resultAddReqParam($proc_rtn, $req_param);
        //계정생성이력 저장
        $this->insertMailAccountManagerLog($req_param);

        return CODE::RETURN_SUCCEED;
    }

    /**계정생성 이력 조회
     * @param $req_param
     * @return array
     */
    public function searchMailAccountManagerLog($req_param)
    {
        //계정생성이력 조회
        $mail_account_manager_log_obj = new TMailAccountManagerLogObj();
        $result = $mail_account_manager_log_obj->load($req_param);

        return[
            'data' => $result
        ];
    }

    /**
     * @param $proc_rtn
     * @param $req_param
     * @return mixed
     */
    private function resultAddReqParam($proc_rtn, $req_param)
    {
        $req_param['procCode'] = $proc_rtn['procCode'];
        $req_param['procMsg'] = $proc_rtn['procMsg'];

        return $req_param;
    }

    /**
     * @param $req_param
     */
    private function insertMailSendLog($req_param)
    {
        $mail_send_log_obj = new TMailSendLogObj();
        $mail_send_log_obj->add($req_param);
    }

    /**
     * @param $req_param
     */
    private function insertMailAccountManagerLog($req_param)
    {
        $mail_account_manager_log_obj = new TMailAccountManagerLogObj();
        $mail_account_manager_log_obj->add($req_param);
    }
}
