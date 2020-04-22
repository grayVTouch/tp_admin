<?php

/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/18
 * Time: 18:46
 */

namespace app\admin\controller;

use function admin\array_to_obj;
use function admin\error;
use function admin\success;
//use function admin\user;
use app\admin\action\WinAction;
use app\admin\model\WinModel;
use app\admin\model\RouteModel;
use app\admin\util\CategoryUtil;

class Win extends Auth {

	public function listView() {
		return $this->fetch('list');
	}

	public function addView() {
		$this->assign([
			'mode' => 'add',
			'bool' => config('business.bool')
		]);
		return $this->fetch('thing');
	}

	public function editView() {
		$param = $this->request->get();
		$param['id'] = $param['id'] ?? '';
		$m = WinModel::findById($param['id']);
		if (empty($m)) {
			return error('未找到id对应记录', 404);
		}
		$this->assign([
			'mode' => 'edit',
			'bool' => config('business.bool'),
			'thing' => $m
		]);
		return $this->fetch('thing');
	}

	public function list() {
		$param = $this->request->post();
		$param['order'] = $param['order'] ?? '';
		$param['limit'] = $param['limit'] ?? '';
		$res = WinAction::list($param);
		if ($res['code'] != 0) {
			return error($res['data'], $res['code']);
		}
		return success($res['data']);
	}

	public function add() {
		$param = $this->request->post();
		$param['key'] = $param['key'] ?? '';
		$param['val'] = $param['val'] ?? '';
		$param['discript'] = $param['discript'] ?? '';
		$res = WinAction::add($param);
		if ($res['code'] != 0) {
			return error($res['data'], $res['code']);
		}
		return success($res['data']);
	}

	public function edit() {
		$param = $this->request->post();
		$param['id'] = $param['id'] ?? '';
		$param['key'] = $param['key'] ?? '';
		$param['val'] = $param['val'] ?? '';
		$param['discript'] = $param['discript'] ?? '';
		$res = WinAction::edit($param);
		if ($res['code'] != 0) {
			return error($res['data'], $res['code']);
		}
		return success($res['data']);
	}

	public function del() {
		$param = $this->request->post();
		$param['id_list'] = $param['id_list'] ?? '';
		$res = WinAction::del($param);
		if ($res['code'] != 0) {
			return error($res['data'], $res['code']);
		}
		return success($res['data']);
	}

	public function update() {
		$param = $this->request->post();
		$param['id'] = $param['id'] ?? '';
		$res = WinAction::update($param);
		if ($res['code'] != 0) {
			return error($res['data'], $res['code']);
		}
		return success($res['data']);
	}

}
