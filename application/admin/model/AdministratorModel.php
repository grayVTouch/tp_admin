<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/6/19
 * Time: 10:32
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_value;
use function admin\image_url;

class AdministratorModel extends Model
{
    protected $table = 'run_administrator';

    public function role()
    {
        return $this->belongsTo(RoleModel::class , 'role_id' , 'id');
    }

    public static function findById(int $id)
    {
        $res = self::with('role')
            ->find($id);
        if (empty($res)) {
            return ;
        }
        self::single($res);
        RoleModel::single($res->role);
        return $res;
    }

    public static function findByUsername($username = '')
    {
        $res = self::with('role')
            ->where('username' , $username)
            ->find();
        if (empty($res)) {
            return ;
        }
        self::single($res);
        RoleModel::single($res->role);
        return $res;
    }

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->avatar_explain = empty($m->avatar) ? config('app.avatar') : image_url($m->avatar);
        $m->status_explain = get_value('business.admin_status' , $m->status);
        $m->is_root_explain = get_value('business.bool' , $m->is_root);
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['username'] = $filter['username'] ?? '';
        $filter['role_id'] = $filter['role_id'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['username'] != '') {
            $where[] = ['username' , 'like' , "%{$filter['username']}%"];
        }
        if ($filter['role_id'] != '') {
            $where[] = ['role_id' , '=' , $filter['role_id']];
        }
        $res = self::with(['role'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            RoleModel::single($v->role);
        }
        return $res;
    }

    public static function isRepeatByUsername($id , $username)
    {
        return (bool) self::where([
                ['id' , '<>' , $id] ,
                ['username' , '=' , $username] ,
            ])
            ->count();
    }
}