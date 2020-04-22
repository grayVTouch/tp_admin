<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\image_url;

class SystemMessageModel extends Model
{
    protected $table = 'tp_system_message';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->simple_content = mb_substr(strip_tags($m->content) , 0 , 100);
        $m->img_explain = image_url($m->img);
        $m->unread_explain = get_value('business.bool' , $m->unread);
    }

    public function typeRelation()
    {
        return $this->belongsTo(SystemMessageTypeModel::class , 'type' , 'type');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        $res = self::with(['type_relation'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->group('msg_id')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            SystemMessageTypeModel::single($v->type_relation);
        }
        return $res;
    }

    // 消息id
    public static function getMsgIdByIds(array $id_list = [])
    {
        return self::whereIn('id' , $id_list)
            ->column('msg_id');
    }

    public static function delByMsgIds(array $msg_ids = [])
    {
        return self::whereIn('msg_id' , $msg_ids)
            ->delete();
    }
}