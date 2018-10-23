<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오전 11:42
 */

namespace Luna\MailManager\Objects\Tables;


class TMailSendLogObj implements TMailSendLogIf
{

    /**
     * 생성하기
     *
     * @param    None
     * @return  ...
     */
    public function add($req_param)
    {
        return MailSendLogRepo::add($req_param);
    }

    /**
     * 불러오기
     *
     * @param    None
     * @return  ...
     */
    public function load($req_param)
    {
        return MailSendLogRepo::load($req_param);

    }
}
