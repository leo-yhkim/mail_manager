<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오전 11:46
 */

namespace Luna\MailManager\Interfaces\Tables;


interface TMailSendLogIf
{

    /**
     * 생성하기
     *
     * @param    None
     * @return  ...
     */
    public function add ($req_param);

    /**
     * 불러오기
     *
     * @param    None
     * @return  ...
     */
    public function load ($req_param);
}
