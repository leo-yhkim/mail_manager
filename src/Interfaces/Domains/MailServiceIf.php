<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-15
 * Time: 오전 11:07
 */

namespace Luna\MailManager\Interfaces\Domains;


interface MailServiceIf
{
    /**메일파라미터처리
     * @param $req_param
     * @return mixed
     */
    public function convertReqToMailFormat($req_param);

    /**메일발송하기
     * @param $mail_message
     * @return mixed
     */
    public function sendMail($mail_message);

    /**계정파라미터처리
     * @param $req_param
     * @return mixed
     */
    public function convertReqToAccountFormat($req_param);

    /**계정생성하기
     * @param $user_info
     * @return mixed
     */
    public function createUserAccount($user_info);
}
