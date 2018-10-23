<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오후 12:17
 */

namespace Luna\MailManager\Repositories;

use Luna\MailManager\Models\Tables\MailSendLog;

class MailSendLogRepo
{
    public static function add($req_param)
    {
        return MailSendLog::create([
            'mail_to'           => $req_param['mailTo'],
            'mail_to_name'      => $req_param['mailToName'],
            'mail_subject'      => $req_param['mailSubject'],
            'mail_contents'     => $req_param['mailContents'],
            'mail_attach'       => $req_param['mailAttachPath'],
            'mail_send_user_id' => 'conn_user_id',
        ]);
    }

    public static function load($req_param)
    {
        return MailSendLog::where('created_at', '>=', $req_param['from_date'])
                            ->where('created_at', '<=', $req_param['to_date'] + 1)->get();
    }
}
