<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class dindan_model extends CI_Model {
	var $pay_platform_list = array ();
	public function __construct() {
		parent::__construct ();
		$this->pay_platform_list = $this->config->item ( 'alipay_pay' ) + $this->config->item ( 'wx_pay' ) + $this->config->item ( 'qq_pay' )  + $this->config->item ( 'own_pay' ) + $this->config->item ( 'jd_pay' ) + $this->config->item ( 'official_alipay_pay' ) + $this->config->item ( 'yl_pay' );
	}
	public function getPayList() {
		return $this->pay_platform_list;
	}
	public function getOrderNum($userid, $dindan, $mystarttime, $myendtime, $account, $order_status, $pay_platform) {
		if ($account && ! $userid) {
			$this->load->model ( 'no3/User_model' );
			$user_info = $this->User_model->getUserInfoByAccount ( $account );
			$userid = $user_info ['id'];
		}
		
		$db = $this->load->database ( 'default', true );
		$db->select ( 'id' );
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		if ($order_status) {
			if ($order_status == 2) {
				$order_status = 0;
			}
			$db->where ( 'status', $order_status );
		}
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		if ($pay_platform) {
			$db->where ( 'pay_platform', $pay_platform );
		}
		
		if ($dindan) {
			$db->where ( 'order_sn', $dindan );
		}
		return $db->count_all_results ();
	}
	
	/*
	 * [170222] add: 新增付费平台参数
	 */
	public function get_dindan_his($userid, $dindan, $third_order_sn, $mystarttime, $myendtime, $account, $order_status, $pay_platform, $start, $per, &$order_list, &$totalNum, $game_code='0') {
		if ($account && ! $userid) {
			$this->load->model ( 'no3/User_model' );
			$user_info = $this->User_model->getUserInfoByAccount ( $account );
			$userid = $user_info ['id'];
		}
		
		$db = $this->load->database ( 'default_slave', true );
		
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		if ($order_status) {
			if ($order_status == 2) {
				$order_status = 0;
			}
			$db->where ( 'status', $order_status );
		}
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		if ($pay_platform) {
			$db->where ( 'pay_platform', $pay_platform );
		}
		
		if ($dindan) {
			$db->where ( 'order_sn', $dindan );
		}
		
		if ($third_order_sn) {
			$db->where ( 'third_order_sn', $third_order_sn );
		}
		
		if('0'!==$game_code && 0!==$game_code && $game_code){
			$db->where ( 'game_code', $game_code );
		}
		
		$db->order_by ( 'add_time', 'DESC' );
		$db->limit ( $per, $start );
		$query = $db->get ();
		$order_list = $query->result_array ();
		if (! empty ( $order_list )) {
			foreach ( $order_list as $k => $v ) {
				if ($v ['status'] == 0) {
					$order_list [$k] ['status'] = '未支付';
				} else if ($v ['status'] == 1) {
					$order_list [$k] ['status'] = '支付成功';
				} else {
					$order_list [$k] ['status'] = '支付失败';
				}
				
				$order_list [$k] ['add_time'] = date ( 'Y-m-d H:i:s', $v ['add_time'] );
				if ($v ['pay_success_time']) {
					$order_list [$k] ['pay_success_time'] = date ( 'Y-m-d H:i:s', $v ['pay_success_time'] );
				} else {
					$order_list [$k] ['pay_success_time'] = ' - ';
				}
				
				$order_list [$k] ['money'] = $v ['money'] / 100;
				
				if ($v ['status'] == 1) {
					$order_list [$k] ['after_chips'] = $v ['before_chips'] + $v ['money'];
				} else {
					$order_list [$k] ['after_chips'] = '--';
				}
				
				if (isset ( $this->pay_platform_list [$v ['pay_platform']] )) {
					$order_list [$k] ['pay_platform'] = $this->pay_platform_list [$v ['pay_platform']];
				} else {
					$order_list [$k] ['pay_platform'] = '--';
				}
			}
		}
		
		// 计算数量
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		if ($order_status) {
			if ($order_status == 2) {
				$order_status = 0;
			}
			$db->where ( 'status', $order_status );
		}
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		if ($pay_platform) {
			$db->where ( 'pay_platform', $pay_platform );
		}
		
		if ($dindan) {
			$db->where ( 'order_sn', $dindan );
		}
		
		if ($third_order_sn) {
			$db->where ( 'third_order_sn', $third_order_sn );
		}
		
		if('0'!==$game_code && 0!==$game_code && $game_code){
			$db->where ( 'game_code', $game_code );
		}
		
		$totalNum = $db->count_all_results ();
	}
	
	/**
	 * [170307] 查询超时订单，超过一分钟为超时订单，超时订单都是成功的订单
	 */
	function get_delay_dindan_his($userid, $mystarttime, $myendtime, $account, $pay_platform, $start, $per, $game_code='0') {
		if ($account && ! $userid) {
			$this->load->model ( 'no3/User_model' );
			$user_info = $this->User_model->getUserInfoByAccount ( $account );
			$userid = $user_info ['id'];
		}
		
		$db = $this->load->database ( 'default_slave', true );
		
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		$db->where ( 'status', 1 );
		$db->where ( '(pay_success_time - add_time) >', 60 );
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		if ($pay_platform) {
			$db->where ( 'pay_platform', $pay_platform );
		}
		
		if('0'!==$game_code && 0!==$game_code && $game_code){
			$db->where ( 'game_code', $game_code );
		}
		
		$db->order_by ( 'add_time', 'DESC' );
		$db->limit ( $per, $start );
		$db->select ( '*, (pay_success_time - add_time) as delayTime' );
		$query = $db->get ();
		$order_list = $query->result_array ();
		if (! empty ( $order_list )) {
			foreach ( $order_list as $k => $v ) {
				if ($v ['status'] == 0) {
					$order_list [$k] ['status'] = '未支付';
				} else if ($v ['status'] == 1) {
					$order_list [$k] ['status'] = '支付成功';
				} else {
					$order_list [$k] ['status'] = '支付失败';
				}
				
				$order_list [$k] ['add_time'] = date ( 'Y-m-d H:i:s', $v ['add_time'] );
				if ($v ['pay_success_time']) {
					$order_list [$k] ['pay_success_time'] = date ( 'Y-m-d H:i:s', $v ['pay_success_time'] );
				} else {
					$order_list [$k] ['pay_success_time'] = ' - ';
				}
				
				$order_list [$k] ['money'] = $v ['money'] / 100;
				
				if ($v ['status'] == 1) {
					$order_list [$k] ['after_chips'] = $v ['before_chips'] + $v ['money'];
				} else {
					$order_list [$k] ['after_chips'] = '--';
				}
				
				if (isset ( $this->pay_platform_list [$v ['pay_platform']] )) {
					$order_list [$k] ['pay_platform'] = $this->pay_platform_list [$v ['pay_platform']];
				} else {
					$order_list [$k] ['pay_platform'] = '--';
				}
				
				$order_list [$k] ['delayTime'] = $this->getDelayTimeText ( $order_list [$k] ['delayTime'] );
			}
		}
		
		// 查询数量
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		$db->where ( 'status', 1 );
		$db->where ( '(pay_success_time - add_time) >', 60 );
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		if ($pay_platform) {
			$db->where ( 'pay_platform', $pay_platform );
		}
		if('0'!==$game_code && 0!==$game_code && $game_code){
			$db->where ( 'game_code', $game_code );
		}
		
		$totalNum = $db->count_all_results ();
		
		return array (
				'orderList' => $order_list,
				'totalNum' => $totalNum 
		);
	}
	
	/**
	 * 获取支付宝转账订单
	 */
	function get_alipay_transfer_dindan_his($userid, $dindan, $alipay_orderid, $mystarttime, $myendtime, $alipay_account, $order_status, $start, $per, &$order_list, &$orderNum) {
		$db = $this->load->database ( 'default', true );
		
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		if ($order_status != - 1) {
			$db->where ( 'status', $order_status );
		}
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		$db->where ( '(pay_platform = ' . PAY_PLATFORM_ZFB_TRANSFER . ' or pay_platform=' . PAY_PLATFORM_ZFB_TRANSFER_WEB . ")" );
		
		if ($dindan) {
			$db->where ( 'order_sn', $dindan );
		}
		
		if ($alipay_orderid) {
			$db->where ( 'third_order_sn', $alipay_orderid );
		}
		
		if ($alipay_account) {
			$db->where ( 'param', $alipay_account );
		}
		
		$db->order_by ( 'add_time', 'DESC' );
		$db->limit ( $per, $start );
		$query = $db->get ();
		$order_list = $query->result_array ();
		if (! empty ( $order_list )) {
			foreach ( $order_list as $k => $v ) {
				$order_list [$k] ['add_time'] = date ( 'Y-m-d H:i:s', $v ['add_time'] );
				if ($v ['pay_success_time']) {
					$order_list [$k] ['pay_success_time'] = date ( 'Y-m-d H:i:s', $v ['pay_success_time'] );
				} else {
					$order_list [$k] ['pay_success_time'] = ' - ';
				}
				
				if ($v ['status'] == 1) {
					$order_list [$k] ['after_chips'] = $v ['before_chips'] + $v ['money'];
				} else {
					$order_list [$k] ['after_chips'] = '--';
				}
			}
		}
		
		// Num
		$db->from ( 'smc_order' );
		if ($userid) {
			$db->where ( 'user_id', $userid );
		}
		
		if ($order_status != - 1) {
			$db->where ( 'status', $order_status );
		}
		
		if ($mystarttime) {
			$db->where ( 'add_time >= ', strtotime ( $mystarttime ) );
		}
		if ($myendtime) {
			$db->where ( 'add_time <= ', strtotime ( $myendtime ) );
		}
		
		$db->where ( '(pay_platform = ' . PAY_PLATFORM_ZFB_TRANSFER . ' or pay_platform=' . PAY_PLATFORM_ZFB_TRANSFER_WEB . ")" );
		
		if ($dindan) {
			$db->where ( 'order_sn', $dindan );
		}
		
		if ($alipay_orderid) {
			$db->where ( 'third_order_sn', $alipay_orderid );
		}
		
		$orderNum = $db->count_all_results ();
		
		return;
	}
	private function getDelayTimeText($sec) {
		if ($sec < 60) {
			return $sec . "秒";
		} else if ($sec < 60 * 60) {
			return intval ( $sec / 60 ) . "分" . ($sec % 60) . "秒";
		} else if ($sec < 24 * 60 * 60) {
			$hour = intval ( $sec / 3600 );
			$minutes = intval ( ($sec % 3600) / 60 );
			$seconds = $sec % 60;
			return $hour . "时" . $minutes . "分" . $seconds . "秒";
		} else {
			$day = intval ( $sec / (3600 * 24) );
			$leftSec = $sec % (3600 * 24);
			$hour = intval ( $leftSec / 3600 );
			$minutes = intval ( ($leftSec % 3600) / 60 );
			$seconds = $leftSec % 60;
			return $day . "天" . $hour . "时" . $minutes . "分" . $seconds . "秒";
		}
	}
	public function budan($order_sn) {
		$db = $this->load->database ( 'default', true );
		$order = $this->getOrder ( $order_sn, $db );
		if (! empty ( $order )) {
			if ($order ['status'] == 0) {
				$data = array (
						'status' => 1,
						'third_order_sn' => $order_sn,
						'pay_success_time' => time () 
				);
				$db->where ( 'order_sn', $order_sn );
				if ($db->update ( 'smc_order', $data )) {
					$this->load->model ( 'detail_model' );
					$gold = intval ( $order ['money'] );
					$this->detail_model->score_operation_by_recharge ( $order ['user_id'], $gold );
					
					$this->load->model ( 'api/User_model' );
					$user_db_index = $this->User_model->getUserDBPos ( $order ['user_id'] );
					if (! empty ( $user_db_index )) {
						$db1 = $this->load->database ( 'eus' . $user_db_index ['dbindex'], true );
						$sql = "UPDATE CASINOUSER_" . $user_db_index ['tableindex'] . " SET totalBuy = totalBuy + '" . $gold . "' WHERE id = '" . $order ['user_id'] . "'";
						$db1->query ( $sql );
						$db1->close ();
					}
					$db->close ();
					
					$redis_config = $this->config->item ( 'redis' );
					$redis = new Redis ();
					$redis->connect ( $redis_config ['host'], $redis_config ['port'] );
					if ($redis->exists ( 'euc_' . $order ['user_id'] )) {
						$redis->incr ( 'euc_' . $order ['user_id'], intval ( $order ['money'] / 100 ) );
					} else {
						$now = time ();
						$expire_time = strtotime ( date ( 'Ymd' . '000000' ) ) + 3600 * 24 - $now;
						$redis->setex ( 'euc_' . $order ['user_id'], $expire_time, intval ( $order ['money'] / 100 ) );
					}
					$redis->close ();
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}
	public function getOrder($agent_bill_id, $db) {
		$db->select ( 'id,status,user_id,money' );
		$db->from ( 'smc_order' );
		$db->where ( 'order_sn', $agent_bill_id );
		$db->limit ( 1 );
		$q = $db->get ();
		return $q->row_array ();
	}
	public function getOrderAllInfo($orderSN) {
		$this->db->select ( '*' );
		$this->db->from ( 'smc_order' );
		$this->db->where ( 'order_sn', $orderSN );
		$this->db->limit ( 1 );
		$q = $this->db->get ();
		$this->db->close ();
		return $q->row_array ();
	}
	function updateMoney($orderid, $money) {
		$db = $this->load->database ( 'default', true );
		$data = array (
				'money' => $money 
		);
		$db->where ( 'order_sn', $orderid );
		return $db->update ( 'smc_order', $data );
	}
	
	private function writeLog($txt) {
		$log_file = "/log/dindan_model.log";
		$handle = fopen ( $log_file, "a+" );
		$dateTime = date("Y-m-d H:i:s", time());
		$str = fwrite ( $handle, "[$dateTime] " . $txt . "\n" );
		fclose ( $handle );
	}
	
}