<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:56
 */

namespace app\admin\model;


use function admin\convert_obj;
use function admin\get_image_url;
use function admin\get_value;
use function admin\image_url;
use function admin\obj_to_array;

class ReportListModel extends Model
{
    protected $table = 'cq_report_list';

    public static function single($m = null)
    {
        if (empty($m)) {
            return ;
        }
        $m->img1_explain = get_image_url($m->img1);
        $m->img2_explain = get_image_url($m->img2);
        $m->img3_explain = get_image_url($m->img3);
        $m->solved_explain = get_value('business.bool' , $m->solved);
    }

    public function reportType()
    {
        return $this->belongsTo(ReportTypeModel::class , 'type' , 'type');
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
        $res = self::with(['report_type'])
            ->where($where)
            ->order($order['field'] , $order['value'])
            ->order('id' , 'asc')
            ->paginate($limit);
        $res = convert_obj($res);
        foreach ($res->data as $v)
        {
            self::single($v);
            ReportTypeModel::single($v->report_type);
        }
        return $res;
    }
}