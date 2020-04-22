<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/29
 * Time: 12:37
 */

namespace app\im\model;


class UserBalanceModel extends Model
{
    protected $table = 'cq_user_balance';

    public function coin()
    {
        return $this->belongsTo(CoinModel::class , 'coin_id' , 'id');
    }

    public static function findByUserIdAndCoinId(int $user_id , int $coin_id)
    {
        $res = self::with('coin')
            ->where([
                ['user_id' , '=' , $user_id] ,
                ['coin_id' , '=' , $coin_id] ,
            ])
            ->find();
        if (empty($res)) {
            return ;
        }
        self::single($res);
        CoinModel::single($res->coin);
        return $res;
    }

    public static function updateByUserId(int $user_id , array $data)
    {
        return self::where('user_id' , $user_id)
            ->update($data);
    }

}