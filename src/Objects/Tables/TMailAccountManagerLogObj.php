<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오후 4:46
 */

namespace Luna\MailManager\Objects\Tables;

use Luna\MailManager\Interfaces\Tables\TMailAccountManagerLogIf;
use Luna\MailManager\Repositories\MailAccountManagerLogRepo;

class TMailAccountManagerLogObj implements TMailAccountManagerLogIf
{

    /**
     * 생성하기
     *
     * @param    None
     * @return  ...
     */
    public function add($req_param)
    {
        return MailAccountManagerLogRepo::add($req_param);
    }

    /**
     * 불러오기
     *
     * @param    None
     * @return  ...
     */
    public function load($req_param)
    {
        return MailAccountManagerLogRepo::load($req_param);
    }
}
