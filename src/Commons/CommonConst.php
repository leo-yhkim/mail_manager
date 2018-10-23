<?php
namespace Luna\MailManager\Commons;

class CommonConst
{
    /*api flag*/
    const GOOGLE_API_GMAIL       = '01';
    const GOOGLE_API_GSUITEADMIN = '02';

    /*return*/
    const RETURN_SUCCEED = 0;
    const RETURN_FAILED = 9;

    /*Account password hash*/
    const HASH_FUNCTION = 'SHA-1';//google 표기
    const HASH_FUNCTION_SET = 'SHA1';//hash 표기

}
