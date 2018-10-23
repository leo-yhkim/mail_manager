<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-15
 * Time: 오전 11:38
 */

namespace Luna\MailManager;

use Luna\MailManager\Objects\Domains\Google\MailServiceGoogleObj;
use Luna\MailManager\Objects\Tables\TMailAccountManagerLogObj;
use Luna\MailManager\Objects\Tables\TMailSendLogObj;

class MailManager
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
        $mail_send = $this->mail_service->sendMail($mail_message);

        //메일전송이력 저장
        $mail_send_log_obj = new TMailSendLogObj();
        $mail_send_log_obj->add($req_param);

        return '성공';
    }

    /**메일발송 이력 조회
     * @param $req_param
     * @return array
     */
    public function loadMailSendLog($req_param)
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
        $user_account_add = $this->mail_service->createUserAccount($user_info);

        //계정생성이력 저장
        $mail_account_manager_log_obj = new TMailAccountManagerLogObj();
        $mail_account_manager_log_obj->add($req_param);

        return '성공';
    }

    /**계정생성 이력 조회
     * @param $req_param
     * @return array
     */
    public function loadMailAccountManagerLog($req_param)
    {
        //계정생성이력 조회
        $mail_account_manager_log_obj = new TMailAccountManagerLogObj();
        $result = $mail_account_manager_log_obj->load($req_param);

        return[
            'data' => $result
        ];
    }
}
