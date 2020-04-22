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
use function admin\obj_to_array;
use function admin\parse_order;
use function admin\user;
use app\admin\lib\Category;
use app\admin\model\OperationLogModel;
use app\admin\model\WinModel;
use app\admin\model\RoleRouteModel;
use think\Db;
use think\Validate;
use Exception;

class WinAction extends Action {

	public static function list(array $param) {
		$param['limit'] = empty($param['limit']) ? config('app.limit') : $param['limit'];
		$order = parse_order($param['order']);
		$res = WinModel::list($param, $order, $param['limit']);
		return self::success($res);
	}

	public static function add(array $param) {
		$validator = Validate::make([
				'key' => 'require',
				'val' => 'require',
				'discript' => 'require',
		]);
		if (!$validator->check($param)) {
			return self::error($validator->getError());
		}
		$id = WinModel::insertGetId(array_unit($param, [
				'key',
				'val',
				'discript',
		]));
		return self::success($id);
	}

	public static function edit(array $param) {
		$validator = Validate::make([
				'id' => 'require',
				'key' => 'require',
				'val' => 'require',
				'discript' => 'require',
		]);
		if (!$validator->check($param)) {
			return self::error($validator->getError());
		}
		$m = WinModel::findById($param['id']);
		if (empty($m)) {
			return self::error('未找到 id 对应项', 404);
		}
		WinModel::updateById($m->id, array_unit($param, [
			'key',
			'val',
			'discript',
		]));
		return self::success($m->id);
	}

	public static function del(array $param) {
		$validator = Validate::make([
				'id_list' => 'require',
		]);
		if (!$validator->check($param)) {
			return self::error($validator->getError());
		}
		$id_list = json_decode($param['id_list'], true);
		if (empty($id_list)) {
			return self::error('请提供待删除项');
		}
		WinModel::delByIds($id_list);
		return self::success('操作成功');
	}

	public static function update(array $param) {
		$validator = Validate::make([
				'id' => 'require',
		]);
		if (!$validator->check($param)) {
			return self::error($validator->getError());
		}
		WinModel::updateById($param['id'], array_unit($param, [
			'val',
		]));
		return self::success('操作成功');
	}

}
