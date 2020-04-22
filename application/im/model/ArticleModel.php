<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/24
 * Time: 12:15
 */

namespace app\im\model;


use function im\convert_obj;
use function im\get_value;
use function im\image_url;

class ArticleModel extends Model
{
    protected $table = 'cq_article';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->thumb_explain = empty($m->thumb) ? config('app.image') : image_url($m->thumb);
        $m->hidden_explain = get_value('business.bool_str' , $m->hidden);

    }

    public function content()
    {
        return $this->hasOne(ArticleContentModel::class , 'article_id' , 'id');
    }

    public static function list(array $filter = [] , array $order = [] , int $limit = 20)
    {
        $filter['id'] = $filter['id'] ?? '';
        $filter['article_type_id'] = $filter['article_type_id'] ?? '';
        $order['field'] = $filter['field'] ?? 'id';
        $order['value'] = $filter['value'] ?? 'desc';
        $where = [];
        if ($filter['id'] != '') {
            $where[] = ['id' , '=' , $filter['id']];
        }
        if ($filter['article_type_id'] != '') {
            $where[] = ['article_type_id' , '=' , $filter['article_type_id']];
        }
        $res = self::with(['content'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            ArticleContentModel::single($v->content);
        }
        return $res;
    }
}