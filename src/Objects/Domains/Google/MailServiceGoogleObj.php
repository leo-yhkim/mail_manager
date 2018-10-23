<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-15
 * Time: 오전 11:26
 */

namespace Luna\MailManager\Objects\Domains\Google;

use Luna\MailManager\CommonConst as CODE;
use Exception;
use Luna\MailManager\Interfaces\Domains\MailServiceIf;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Swift_Attachment;
use Swift_Message;

class MailServiceGoogleObj implements MailServiceIf
{

    private $google_userid = 'me';//인증 gmail 계정으로 세팅되는 특수 고정값
    private $google_client;

    public function __construct()
    {
        $this->google_client = new GoogleClient();
    }

    /**
     * @param $req_param
     * @return Google_Service_Gmail_Message
     */
    public function convertReqToMailFormat($req_param)
    {
        $g_mail_message = $this->convertReqToMailData($req_param);
        $mail_message= $this->convertMailDataToMailMessage($g_mail_message);

        return $mail_message;
    }

    /**
     * @param $mail_message
     * @return array
     */
    public function sendMail($mail_message)
    {
        try {
            $client = $this->google_client->getClient(CODE::GOOGLE_API_GMAIL);
            $service = new Google_Service_Gmail($client);
            $mail_send = $service->users_messages->send($this->google_userid, $mail_message);

            $proc_rtn = [
                'procCode' => CODE::RETURN_SUCCEED,
                'procMsg' => $mail_send->getId(),
            ];
        } catch (Exception $e) {
        }finally{
            if(isset($e)){
                $proc_rtn = [
                    'procCode' => CODE::RETURN_FAILED,
                    'procMsg' => $e->getMessage(),
                ];
            }
            return $proc_rtn;
        }

    }

    /**
     * @param $req_param
     * @return Google_Service_Directory_User
     */
    public function convertReqToAccountFormat($req_param)
    {
        $user_info = $this->convertReqToAccountInfo($req_param);

        return $user_info;
    }

    /**
     * @param $user_info
     * @return array
     */
    public function createUserAccount($user_info)
    {
        try{
            $client = $this->google_client->getClient(CODE::GOOGLE_API_GSUITEADMIN);
            $service = new Google_Service_Directory($client);
            $user_account_add = $service->users->insert($user_info);

            $proc_rtn = [
                'procCode' => CODE::RETURN_SUCCEED,
                'procMsg' => $user_account_add->getId(),
            ];
        } catch (Exception $e) {
        }finally{
            if(isset($e)){
                $proc_rtn = [
                    'procCode' => CODE::RETURN_FAILED,
                    'procMsg' => $e->getMessage(),
                ];
            }
            return $proc_rtn;
        }

    }

    /**
     * @param $req_param
     * @return Swift_Message
     */
    private function convertReqToMailData($req_param)
    {
        $g_mail_message = new Swift_Message();
        $g_mail_message->setTo($req_param['mailTo'], $req_param['mailToName']);
        $g_mail_message->setSubject($req_param['mailSubject']. date('M d, Y h:i:s A'));
        $g_mail_message->setBody($req_param['mailContents'], 'text/html', 'utf-8');
        if (isset($req_param['mailAttachPath']) && isset($req_param['mailAttachFileName'])) {
            $target_path = config('app.gmail_attach_file_path'). $req_param['mailAttachFileName'];
            if(move_uploaded_file($req_param['mailAttachPath'], $target_path)){
                $g_mail_message->attach(Swift_Attachment::fromPath($target_path));
                //if we don't want to keep the image
                //unlink($target_path);
            }
        }
        return $g_mail_message;
    }

    /**
     * @param Swift_Message $g_mail_message
     * @return Google_Service_Gmail_Message
     */
    private function convertMailDataToMailMessage(Swift_Message $g_mail_message)
    {
        $mail_message = new Google_Service_Gmail_Message();
        $mime = rtrim(strtr(base64_encode($g_mail_message), '+/', '-_'), '=');
        $mail_message->setRaw($mime);

        return $mail_message;
    }

    /**
     * @param $req_param
     * @return Google_Service_Directory_User
     */
    private function convertReqToAccountInfo($req_param)
    {
        $user_name = new Google_Service_Directory_UserName();
        $user_info = new Google_Service_Directory_User();

        $user_name->setFamilyName($req_param['familyName']);
        $user_name->setGivenName($req_param['givenName']);
        $user_name->setFullName($req_param['fullName']);

        $user_info->setPrimaryEmail($req_param['primaryEmail']);
        $user_info->setName($user_name);
        $user_info->setHashFunction(CODE::HASH_FUNCTION);
        $user_info->setPassword(hash(CODE::HASH_FUNCTION_SET, $req_param['password']));

        return $user_info;
    }

}
