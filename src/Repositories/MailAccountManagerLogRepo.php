<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오후 4:21
 */

namespace Luna\MailManager\Repositories;

use Luna\MailManager\Models\Tables\MailAccountManagerLog;

class MailAccountManagerLogRepo
{
    public static function add($req_param)
    {
        return MailAccountManagerLog::create([
            'family_name'           => $req_param['familyName'],
            'given_name'      => $req_param['givenName'],
            'full_name'      => $req_param['fullName'],
            'primary_email'       => $req_param['primaryEmail'],
            'account_add_user_id' => 'conn_user_id',
        ]);
    }


    public static function load($list_date)
    {
        return MailAccountManagerLog::where('created_at', '>=', $list_date['from_date'])
                              ->where('created_at', '<=', $list_date['to_date'] + 1)->get();
    }
}
