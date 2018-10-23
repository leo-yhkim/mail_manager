<?php
/**
 * Created by IntelliJ IDEA.
 * User: lunasoftPC35
 * Date: 2018-10-16
 * Time: 오후 4:20
 */

namespace Luna\MailManager\Models\Tables;


use Illuminate\Database\Eloquent\Model;

class MailAccountManagerLog extends Model
{
    protected $primaryKey = 'seq';
    protected $guarded = [
        'seq',
        'created_at',
        'updated_at',
    ];
}
