<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 11:53
 */

namespace app\admin\action;


use function admin\array_unit;
use function admin\get_value;
use function admin\parse_order;
use function admin\user;
use app\admin\model\OperationLogModel;
use app\admin\model\UserModel;
use think\Db;
use think\Validate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Exception;

class UserAction extends Action
{
    public static function list(array $param)
    {
        $param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
        $order = parse_order($param['order']);
        $res = UserModel::list($param , $order , $param['limit']);
        return self::success($res);
    }

    public static function update(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        UserModel::updateById($param['id'] , array_unit($param , [
            'pay_pass' ,
            'status' ,
            'is_verify' ,
        ]));
        return self::success('操作成功');
    }

    public static function edit(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $user = UserModel::findById($param['id']);
        if (empty($user)) {
            return self::error('找不到用户' , 404);
        }
        if (UserModel::isRepeatByUsername($param['id'] , $param['username'])) {
            return self::error('用户名已经被使用' , 400);
        }
        if (UserModel::isRepeatByPhone($param['id'] , $param['phone'])) {
            return self::error('手机号码已经被使用' , 400);
        }
        $param['username'] = empty($param['username']) ? $user->username : $param['username'];
        $param['phone'] = empty($param['phone']) ? $user->phone : $param['phone'];
        $param['password'] = empty($param['password']) ? $user->password : md5($param['password']);
        $param['pay_pass'] = empty($param['pay_pass']) ? $user->pay_pass : $param['pay_pass'];
        UserModel::updateById($param['id'] , array_unit($param , [
            'username' ,
            'phone' ,
            'password' ,
            'pay_pass' ,
        ]));
        return self::success('操作成功');
    }

    public static function relation(array $param)
    {
        $validator = Validate::make([
            'id' => 'require' ,
        ]);
        if (!$validator->check($param)) {
            return self::error($validator->getError());
        }
        $user = UserModel::findById($param['id']);
        if (empty($user)) {
            return self::error('找不到用户' , 404);
        }
        $children = UserModel::childrenById($param['id'] , true);
        return self::success($children);
    }

    public static function exportExcel()
    {
        $max_executation_time = ini_get('max_execution_time');
        $memory_limit = ini_get('memory_limit');
        ini_set('max_execution_time' , 0);
        ini_set('memory_limit' , '512M');
        $users = UserModel::getAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', '用户编号');
        $sheet->setCellValue('B1', '用户名');
        $sheet->setCellValue('C1', '邀请人');
        $sheet->setCellValue('D1', '联系电话');
        $sheet->setCellValue('E1', '直推人数');
        $sheet->setCellValue('F1', '注册时间');
        foreach ($users as $k => $v)
        {
            $v->directInviteUserCount = UserModel::directInviteUserCount($v->id);
            $sheet->setCellValue('A' . ($k + 2), $v->id);
            $sheet->setCellValue('B' . ($k + 2), $v->username);
            $sheet->setCellValue('C' . ($k + 2), $v->parent ? sprintf('%s【%s】' , $v->parent->username , $v->pid) : $v->pid);
            $sheet->setCellValue('D' . ($k + 2), $v->phone);
            $sheet->setCellValue('E' . ($k + 2), $v->directInviteUserCount);
            $sheet->setCellValue('F' . ($k + 2), $v->date);
        }
        $excel_dir = config('app.excel_dir');
        $writer = new Xlsx($spreadsheet);
        $filename = sprintf('用户数据-%s.xlsx' , date('YmdHis' , time()));
        $file = sprintf('%s%s' , $excel_dir , $filename);
        $writer->save($file);
        $content = file_get_contents($file);
        unlink($file);
        ini_set('max_execution_time' , $max_executation_time);
        ini_set('memory_limit' , $memory_limit);
        return self::success([
            'filename' => $filename ,
            'content' => $content
        ]);
    }
}