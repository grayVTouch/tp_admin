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
use function admin\obj_to_array;
use function admin\res_url;

class UserModel extends Model
{
    protected $table = 'tp_user';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
//        $m->status_explain = get_value('business.user_status' , $m->status);
//        $m->robot_explain = get_value('business.bool' , $m->robot);
        $m->avatar_explain = res_url($m->avatar);
    }

    public static function isRepeatByUsername($id , $username)
    {
        return (bool) self::where([
            ['id' , '<>' , $id] ,
            ['username' , '=' , $username] ,
        ])->count();
    }

    public static function isRepeatByPhone($id , $phone)
    {
        return (bool) self::where([
            ['id' , '<>' , $id] ,
            ['phone' , '=' , $phone] ,
        ])->count();
    }

    // 查找下级
    public static function childrenById($id , bool $save_self = false , array &$result = [] , int $floor = 1)
    {
        $children = self::where([
                ['pid' , '=' , $id] ,
            ])
            ->select();
        $children = obj_to_array($children);
        foreach ($children as &$v)
        {
            self::childrenById($v['id'] ,false , $result , $floor + 1);
        }
        if ($floor == 1 && $save_self) {
            $my = self::findById($id);
            $my = obj_to_array($my);
            $result[] = $my;
            array_splice($result , count($result) , 0 , $children);
            return $result;
        }
        array_splice($result , count($result) , 0 , $children);
        return $result;
    }

    public static function getAll()
    {
        $res = self::with(['parent'])
            ->all();
        foreach ($res as $v)
        {
            self::single($v);
            self::single($v->parent);
        }
        return $res;
    }

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


}