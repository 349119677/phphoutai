<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class cardmgr extends CI_Controller {
	public function __construct() {
		parent::__construct ( false, false );
		if (! $this->Common_model->isLogin () || !$this->session->userdata('admin_name')) {
			redirect ( 'no3/login' );
		}
		if (! $this->Common_model->isPriv ( 'cwgl_card' )) {
			redirect ( 'no3/index' );
		}
		$this->load->model ( 'task/cus_card_model' );
		$this->load->model ( 'no3/Admin_model' );
	}
	public function index() {
		$this->writeLog("cardmgr--------------------------");
		$query ['id'] = $this->input->get ( 'id', true ) ? intval ( $this->input->get ( 'id', true ) ) : 0;
		$query ['status'] = $this->input->get ( 'status', true ) ? intval ($this->input->get ( 'status', true )) : '';
		$query ['bankcard_no'] = $this->input->get ( 'bankcard_no', true ) ? intval ( $this->input->get ( 'bankcard_no', true ) ) : '';
		$query ['bank_branch'] = $this->input->get ( 'bank_branch', true ) ? $this->input->get ( 'bank_branch', true ) : '';
		$query ['cardholder_name'] = $this->input->get ( 'cardholder_name', true ) ? $this->input->get ( 'cardholder_name', true ) : '';
		$query ['cardholder_mobile'] = $this->input->get ( 'cardholder_mobile', true ) ? $this->input->get ( 'cardholder_mobile', true ) : '';
		$query ['adduser'] = $this->input->get ( 'adduser', true ) ? $this->input->get ( 'adduser', true ) : '';
		$query ['describe'] = $this->input->get ( 'describe', true ) ? $this->input->get ( 'describe', true ) : '';
		
		$query ['start_time'] = $this->input->get ( 'start_time', true ) ? $this->input->get ( 'start_time', true ) : date ( 'Y-m-d', strtotime ( '-1000 day' ) );
		$query ['end_time'] = $this->input->get ( 'end_time', true ) ? $this->input->get ( 'end_time', true ) : date ( 'Y-m-d', strtotime ( '1 day' ));
		
		$admin_name=$this->session->userdata('admin_name');
		
		$per = 10;
		$page = $this->input->get ( 'page' ) ? intval ( $this->input->get ( 'page' ) ) : 1;
		$start = ($page - 1) * $per;
		
		$data = array (
				'menu' => $this->Common_model->getAdminMenuList (),
				"choose" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理" 
				),
				"header1" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理" 
				),
				'cash_order_list' => $this->cus_card_model->getCardList ( $query ['id'], $query ['status'], $query ['bankcard_no'],$query ['bank_branch'], $query ['cardholder_name'], $query ['cardholder_mobile'], $query ['adduser'], $query ['describe'], $query ['start_time'], $query ['end_time'], $per, $start, $admin_name),
				'query' => $query
		);
		$data ['total_rows'] = $this->cus_card_model->getCardNum ( $query ['id'], $query ['status'], $query ['bankcard_no'],$query ['bank_branch'], $query ['cardholder_name'], $query ['cardholder_mobile'], $query ['adduser'], $query ['describe'], $query ['start_time'], $query ['end_time'], $admin_name );
		$this->load->library ( 'pagination' );
		$config ['base_url'] = site_url ( 'task/cardmgr/index' ) . '?id='.$query ['id'].'&status=' . $query ['status'] . '&bankcard_no=' . $query ['bankcard_no']. '&bank_branch=' . $query ['bank_branch'] . '&cardholder_name=' . $query ['cardholder_name'] . '&adduser=' . $query ['adduser'] . '&describe='.$query ['describe']. '&start_time=' . $query ['start_time'] . '&end_time=' . $query ['end_time'];
		$config ['total_rows'] = $data ['total_rows'];
		$config ['per_page'] = $per;
		$this->pagination->initialize ( $config );
		$this->load->view ( 'task/cardmgr_views', $data );
	}
	public function createNewCard()
	{
		$data = array (
				'menu' => $this->Common_model->getAdminMenuList (),
				"choose" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理"
				),
				"header1" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理"
				),
				"header2" => array(
						"father"=>"代付帐户管理",
						"child"=>"代付帐户创建 "
				),
		);
		$this->load->view ( 'task/cardnew_views', $data );
	}
	
	public function ajaxAddCardNew() {
		$this->writeLog("ajaxAddCardNew-------------------------");
		$this->writeLog ( '[NOTIFY] POST: ' . json_encode ( $_POST ) );
		$this->writeLog ( '[NOTIFY] GET: ' . json_encode ( $_GET ) );
		$status = 'y';//状态： 1 开启， 2 关闭
		$addtime = date('Y-m-d H:i:s',time());
		$adduser = $this->session->userdata('admin_name');
		$bankcard_no = $this->input->post ( 'bankcard_no' ) ? $this->input->post ( 'bankcard_no' ) : "";
		$bank_branch = $this->input->post ( 'bank_branch' ) ? $this->input->post ( 'bank_branch' ) : "";
		$cardholder_name = $this->input->post ( 'cardholder_name' ) ? $this->input->post ( 'cardholder_name' ) : "";
		$cardholder_mobile = $this->input->post ( 'cardholder_mobile' ) ? $this->input->post ( 'cardholder_mobile' ) : "";
		$describe = $this->input->post ( 'describe' ) ? $this->input->post ( 'describe' ) : "";
		
		$customer_type = $this->input->post ( 'customer_type' ) ? $this->input->post ( 'customer_type' ) : "01";
		$account_type = $this->input->post ( 'account_type' ) ? $this->input->post ( 'account_type' ) : "01";
		$pay_password = $this->input->post ( 'pay_password' ) ? $this->input->post ( 'pay_password' ) : "";
		$headquarters_bank_id = $this->input->post ( 'headquarters_bank_id' ) ? $this->input->post ( 'headquarters_bank_id' ) : "";
		$issue_bank_id = $this->input->post ( 'issue_bank_id' ) ? $this->input->post ( 'issue_bank_id' ) : "";
		
		if (!$bankcard_no || !$bank_branch || !$cardholder_name) {
			$return_ary = array (
					'status' => '0',
					'msg' => '参数错误！'
			);
			$this->writeLog("0 参数错误 ");
			exit ( json_encode ( $return_ary ) );
			return;
		}
		$bank_branch = trim(urldecode($bank_branch));
		$cardholder_name = trim(urldecode($cardholder_name));
		$describe = trim(urldecode($describe));
		
		$customer_type = trim(urldecode($customer_type));
		$account_type = trim(urldecode($account_type));
		$pay_password = trim(urldecode($pay_password));
		$headquarters_bank_id = trim(urldecode($headquarters_bank_id));
		$issue_bank_id = trim(urldecode($issue_bank_id));
		
		if (!$bankcard_no || !$bank_branch || !$cardholder_name) {
			$return_ary = array (
					'status' => '0',
					'msg' => '参数错误！'
			);
			$this->writeLog("1 参数错误 ");
			exit ( json_encode ( $return_ary ) );
			return;
		}
		$uuid = md5(uniqid());
		$data = array (
				'addtime' => $addtime,
				'adduser' => $adduser,
				'bankcard_no' => $bankcard_no,
				'bank_branch' => $bank_branch,
				'cardholder_name' => $cardholder_name,
				'cardholder_mobile' => $cardholder_mobile,
				'describe' => $describe,
				'customer_type' => $customer_type,
				'account_type' => $account_type,
				'pay_password' => $pay_password,
				'headquarters_bank_id' => $headquarters_bank_id,
				'issue_bank_id' => $issue_bank_id,
				'status' => $status,
				'uuid' => $uuid
		);
		$flag = $this->cus_card_model->addCardNew($data);
		$this->writeLog("2 $flag $uuid");
		$return_ary = array (
				'status' => '0',
				'adduser' => $adduser,
				'time' => date('Y-m-d H:i:s',time()),
				'msg' => '保存失败'
		);
		$res = $this->cus_card_model->getCardId($uuid);
		if($flag && !empty ( $res ) && $res['id'])
		{
			$return_ary = array (
					'status' => '1',
					'adduser' => $adduser,
					'time' => date('Y-m-d H:i:s',time()),
					'task_id' => $res['id'],
					'msg' => '成功'
			);
		}
		$res_json = json_encode ( $return_ary );
		$this->writeLog("3 $res_json");
		exit ( $res_json );
	}
	
	public function cardInfo(){
		$id = $this->input->get ( 'id' ) ? $this->input->get ( 'id' ) : 0;
		if (! $id) {
			$this->session->set_flashdata ( 'error', '参数错误1' );
			redirect ( 'task/cardmgr' );
		}
		else{
			$cardInfo = $this->cus_card_model->getCardInfo ( $id );
			$cardExpPai = array();
			if($cardInfo && $cardInfo['bankcard_no']){
				$cardExpPai = $this->cus_card_model->getCardInfoExpPai($cardInfo['bankcard_no']);
			}
			$data = array (
					'menu' => $this->Common_model->getAdminMenuList (),
					"choose" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理"
					),
					"header1" => array (
							"father" => "财务管理",
							"child" => "代付帐户详情"
					),
					"header2" => array(
							"father"=>"代付帐户管理",
							"child"=>"代付帐户详情 "
					),
					'adduser' => $this->session->userdata('admin_name'),
					'infoExpPai' => $cardExpPai,
					'notice' => $cardInfo,
			);
			$this->load->view ( 'task/cardinfo_views', $data );
		}
	}
	
	/**
	 * 修改界面
	 */
	public function modify()
	{
		$id = $this->input->get ( 'id' ) ? intval($this->input->get ( 'id' )) : 0;
		if (! $id) {
			$this->session->set_flashdata ( 'error', '参数错误1' );
			redirect ( 'task/cardmgr' );
		}
		else{
			$data = array (
					'menu' => $this->Common_model->getAdminMenuList (),
					"choose" => array (
						"father" => "财务管理",
						"child" => "代付帐户管理"
					),
					"header1" => array (
							"father" => "财务管理",
							"child" => "代付帐户详情"
					),
					"header2" => array(
							"father"=>"代付帐户管理",
							"child"=>"代付帐户详情 "
					),
					'adduser' => $this->session->userdata('admin_name'),
					'info' => $this->cus_card_model->getCardInfo ( $id )
			);
			$this->load->view ( 'task/cardmodify_view', $data );
		}
	}
	
	/**
	 * 修改操作
	 */
	public function ajaxModifyCard()
	{
		$id = $this->input->get ( 'id' ) ? $this->input->get ( 'id' ) : 0;
		if (! $id) {
			$return_ary = array (
					'status' => '0',
					'msg' => '参数错误！'
			);
			exit ( json_encode ( $return_ary ) );
		}

		$bankcard_no = $this->input->post ( 'bankcard_no' ) ? $this->input->post ( 'bankcard_no' ) : "";
		$bank_branch = $this->input->post ( 'bank_branch' ) ? $this->input->post ( 'bank_branch' ) : "";
		$cardholder_name = $this->input->post ( 'cardholder_name' ) ? $this->input->post ( 'cardholder_name' ) : "";
		$cardholder_mobile = $this->input->post ( 'cardholder_mobile' ) ? $this->input->post ( 'cardholder_mobile' ) : "";
		$describe = $this->input->post ( 'describe' ) ? $this->input->post ( 'describe' ) : "";

		$customer_type = $this->input->post ( 'customer_type' ) ? $this->input->post ( 'customer_type' ) : "01";
		$account_type = $this->input->post ( 'account_type' ) ? $this->input->post ( 'account_type' ) : "01";
		$pay_password = $this->input->post ( 'pay_password' ) ? $this->input->post ( 'pay_password' ) : "";
		$headquarters_bank_id = $this->input->post ( 'headquarters_bank_id' ) ? $this->input->post ( 'headquarters_bank_id' ) : "";
		$issue_bank_id = $this->input->post ( 'issue_bank_id' ) ? $this->input->post ( 'issue_bank_id' ) : "";
		
		$bank_branch = trim(urldecode($bank_branch));
		$cardholder_name = trim(urldecode($cardholder_name));
		$describe = trim(urldecode($describe));
		
		$customer_type = trim(urldecode($customer_type));
		$account_type = trim(urldecode($account_type));
		$pay_password = trim(urldecode($pay_password));
		$headquarters_bank_id = trim(urldecode($headquarters_bank_id));
		$issue_bank_id = trim(urldecode($issue_bank_id));
		
		$modifyData = array(
				'bankcard_no' => $bankcard_no,
				'bank_branch' => $bank_branch,
				'cardholder_name' => $cardholder_name,
				'cardholder_mobile' => $cardholder_mobile,
				'describe' => $describe,
				'customer_type' => $customer_type,
				'account_type' => $account_type,
				'pay_password' => $pay_password,
				'headquarters_bank_id' => $headquarters_bank_id,
				'issue_bank_id' => $issue_bank_id,
				);
	
		if (!$this->cus_card_model->modifyOneCard($id, $modifyData))
		{
			$return_ary = array (
					'status' => '0',
					'msg' => '修改失败！'
			);
			exit ( json_encode ( $return_ary ) );
		}

		$return_ary = array (
				'status' => '1',
				'msg' => 'OK'
		);
		exit ( json_encode ( $return_ary ) );
	}
	

	/**
	 * 删除
	 */
	public function delete()
	{
		$id = $this->input->get ( 'id' ) ? $this->input->get ( 'id' ) : 0;
		if (! $id) {
			$this->session->set_flashdata ( 'error', '参数错误1' );
		}
		else{
			$this->cus_card_model->deleteOneCard($id);
			$this->session->set_flashdata ( 'success', '删除成功' );
		}

		redirect ( 'task/cardmgr' );
	}
	
	public function batchClose() {
		$admin_id = $this->session->userdata ( 'id' );
		$select_cash_ids = $this->input->post ( 'select_cash_ids' );
		if (empty ( $select_cash_ids )) {
			$this->session->set_flashdata ( 'error', '请选择任务' );
			redirect ( 'task/cardmgr' );
		}
	
		$data = array (
				'status' => 'n',
				'update_user' => $adduser = $this->session->userdata('admin_name'),
				'update_time' => time ()
		);
	
		$num = 0 ;
		foreach ( $select_cash_ids as $id ) {
			$num++;
			$flag = $this->cus_card_model->updatecard($id, $data);
		}
	
		$this->session->set_flashdata ( 'success', '禁用成功'.$num );
		redirect ( 'task/cardmgr' );
	}
	
	public function writeLog($txt) {
		$log_file = "/log/cardmgr.log";
		$handle = fopen ( $log_file, "a+" );
		$dateTime = date("Y-m-d H:i:s", time());
		$str = fwrite ( $handle, "[$dateTime] " . $txt . "\n" );
		fclose ( $handle );
	}
	
	
	public function modifyExpandedMsg(){
		$id = $this->input->get ( 'id' ) ? intval($this->input->get ( 'id' )) : 0;
		if (! $id) {
			$this->session->set_flashdata ( 'error', '参数错误1' );
			redirect ( 'task/cardmgr' );
		}
		else{
			$cardInfo = $this->cus_card_model->getCardInfo ( $id );
			$cardExpPai = array();
			if($cardInfo && $cardInfo['bankcard_no']){
				$cardExpPai = $this->cus_card_model->getCardInfoExpPai($cardInfo['bankcard_no']);
			}
			$data = array (
					'menu' => $this->Common_model->getAdminMenuList (),
					"choose" => array (
							"father" => "财务管理",
							"child" => "代付帐户管理"
					),
					"header1" => array (
							"father" => "财务管理",
							"child" => "代付帐户扩展详情"
					),
					"header2" => array(
							"father"=>"代付帐户管理",
							"child"=>"代付帐户扩展详情 "
					),
					'adduser' => $this->session->userdata('admin_name'),
					'infoBase' => $cardInfo,
					'infoExpPai' => $cardExpPai,
					'bankCodes'=>$this->getBankCodeArrPai(),//银行代码
					'provinceCodes'=>$this->getProvinceCodeArrPai(),//省份代码
					'cityCodes'=>$this->getCityCodeArrPai(),//城市代码
			);
			$this->load->view ( 'task/cardmodify_exp_view', $data );
		}
	}
	
	public function ajaxModifyCardExp(){
		$this->writeLog("ajaxModifyCardExp-------------------------");
		$this->writeLog ( '[NOTIFY] POST: ' . json_encode ( $_POST ) );
		$this->writeLog ( '[NOTIFY] GET: ' . json_encode ( $_GET ) );
		$bankcard_no = $this->input->post ( 'bankcard_no' ) ? $this->input->post ( 'bankcard_no' ) : "";
		$bank_code = $this->input->post ( 'bank_code' ) ? $this->input->post ( 'bank_code' ) : "";
		$province_code = $this->input->post ( 'province_code' ) ? $this->input->post ( 'province_code' ) : "";
		$city_code = $this->input->post ( 'city_code' ) ? $this->input->post ( 'city_code' ) : "";

		$bankcard_no = str_replace( " ", "",$bankcard_no);
		$bank_code = str_replace( " ", "",$bank_code);
		$province_code = str_replace( " ", "",$province_code);
		$city_code = str_replace( " ", "",$city_code);
		
		if(!$bankcard_no || !$bank_code || !$province_code || !$city_code){
			$return_ary = array (
					'status' => '0',
					'msg' => '参数不可空！'
			);
			exit ( json_encode ( $return_ary ) );
		}
		
		$modifyData = array(
				'bank_code' => $bank_code,
				'province_code' => $province_code,
				'city_code' => $city_code,
				'addtime' => date('Y-m-d H:i:s',time()),
				'adduser' => $this->session->userdata('admin_name'),
		);
		
		if (!$this->cus_card_model->modifyCardInfoExpPai($bankcard_no, $modifyData))
		{
			$return_ary = array (
					'status' => '0',
					'msg' => '保存失败！'
			);
			exit ( json_encode ( $return_ary ) );
		}
		
		$return_ary = array (
				'status' => '1',
				'msg' => '保存成功'
		);
		exit ( json_encode ( $return_ary ) );
	}
	
	private function getBankCodeArrPai(){
		$codes = array(
				'ABC'=>'中国农业银行',
				'ICBC'=>'中国工商银行',
				'CCB'=>'中国建设银行',
				'BCOM'=>'交通银行',
				'BOC'=>'中国银行',
				'CMB'=>'招商银行',
				'CMBC'=>'中国民生银行',
				'CEBB'=>'光大银行',
				'CIB'=>'兴业银行',
				'PSBC'=>'中国邮政储蓄银行',
				'SPABANK'=>'平安银行',
				'ECITIC'=>'中信银行',
				'GDB'=>'广东发展银行',
				'HXB'=>'华夏银行',
				'SPDB'=>'浦发银行',
				'BEA'=>'东亚银行',
				'BOB'=>'北京银行',
				'SHB'=>'上海银行',
				'NBB'=>'宁波银行',
				'BHB'=>'河北银行',
				'HSBANK'=>'徽商银行',
				);
		return $codes;
	}
	private function getProvinceCodeArrPai(){
		$provinceCodes = array(
				'11'=>'北京市',
				'12'=>'天津市',
				'13'=>'河北省',
				'14'=>'山西省',
				'15'=>'内蒙古',
				'21'=>'辽宁省',
				'22'=>'吉林省',
				'23'=>'黑龙江省',
				'31'=>'上海市',
				'32'=>'江苏省',
				'33'=>'浙江省',
				'34'=>'安徽省',
				'35'=>'福建省',
				'36'=>'江西省',
				'37'=>'山东省',
				'41'=>'河南省',
				'42'=>'湖北省',
				'43'=>'湖南省',
				'44'=>'广东省',
				'45'=>'广西壮族自治区',
				'46'=>'海南省',
				'50'=>'重庆市',
				'51'=>'四川省',
				'52'=>'贵州省',
				'53'=>'云南省',
				'54'=>'西藏自治区',
				'61'=>'陕西省',
				'62'=>'甘肃省',
				'63'=>'青海省',
				'64'=>'宁夏回族自治区',
				'65'=>'新疆维吾尔自治区',
				'71'=>'台湾',
				'81'=>'香港特别行政区',
				'82'=>'澳门特别行政区',
				);
		return $provinceCodes;
	}
	private function getCityCodeArrPai(){
		$cityCodes = array(
				'1000'=>'北京市',
				'1100'=>'天津市',
				'1210'=>'石家庄市',
				'1240'=>'唐山市',
				'1260'=>'秦皇岛市',
				'1270'=>'邯郸市',
				'1310'=>'邢台市',
				'1340'=>'保定市',
				'1380'=>'张家口市',
				'1410'=>'承德市',
				'1430'=>'沧州市',
				'1460'=>'廊坊市',
				'1480'=>'衡水市',
				'1610'=>'太原市',
				'1620'=>'大同市',
				'1630'=>'阳泉市',
				'1640'=>'长治市',
				'1680'=>'晋城市',
				'1690'=>'朔州市',
				'1710'=>'忻州市',
				'1730'=>'吕梁市',
				'1750'=>'晋中市',
				'1770'=>'临汾市',
				'1810'=>'运城市',
				'1910'=>'呼和浩特市',
				'1920'=>'包头市',
				'1930'=>'乌海市',
				'1940'=>'赤峰市',
				'1960'=>'呼伦贝尔市',
				'1980'=>'兴安盟',
				'1990'=>'通辽市',
				'2010'=>'锡林郭勒盟',
				'2030'=>'乌兰察布市',
				'2050'=>'鄂尔多斯市',
				'2070'=>'巴彦淖尔市',
				'2080'=>'阿拉善盟',
				'2210'=>'沈阳市',
				'2220'=>'大连市',
				'2230'=>'鞍山市',
				'2240'=>'抚顺市',
				'2250'=>'本溪市',
				'2260'=>'丹东市',
				'2270'=>'锦州市',
				'2276'=>'葫芦岛市',
				'2280'=>'营口市',
				'2290'=>'阜新市',
				'2310'=>'辽阳市',
				'2320'=>'盘锦市',
				'2330'=>'铁岭市',
				'2340'=>'朝阳市',
				'2410'=>'长春市',
				'2420'=>'吉林市',
				'2430'=>'四平市',
				'2440'=>'辽源市',
				'2450'=>'通化市',
				'2460'=>'白山市',
				'2470'=>'白城市',
				'2490'=>'延边朝鲜族自治州',
				'2520'=>'松原市',
				'2610'=>'哈尔滨市',
				'2640'=>'齐齐哈尔市',
				'2650'=>'大庆市',
				'2660'=>'鸡西市',
				'2670'=>'鹤岗市',
				'2680'=>'双鸭山市',
				'2690'=>'佳木斯市',
				'2710'=>'伊春市',
				'2720'=>'牡丹江市',
				'2740'=>'七台河市',
				'2760'=>'绥化市',
				'2780'=>'黑河市',
				'2790'=>'大兴安岭地区',
				'2900'=>'上海市',
				'3010'=>'南京市',
				'3020'=>'无锡市',
				'3030'=>'徐州市',
				'3040'=>'常州市',
				'3050'=>'苏州市',
				'3060'=>'南通市',
				'3070'=>'连云港市',
				'3080'=>'淮安市',
				'3090'=>'宿迁市',
				'3110'=>'盐城市',
				'3120'=>'扬州市',
				'3128'=>'泰州市',
				'3140'=>'镇江市',
				'3310'=>'杭州市',
				'3320'=>'宁波市',
				'3330'=>'温州市',
				'3350'=>'嘉兴市',
				'3360'=>'湖州市',
				'3370'=>'绍兴市',
				'3380'=>'金华市',
				'3410'=>'衢州市',
				'3420'=>'舟山市',
				'3430'=>'丽水市',
				'3450'=>'台州市',
				'3610'=>'合肥市',
				'3620'=>'芜湖市',
				'3630'=>'蚌埠市',
				'3640'=>'淮南市',
				'3650'=>'马鞍山市',
				'3660'=>'淮北市',
				'3670'=>'铜陵市',
				'3680'=>'安庆市',
				'3710'=>'黄山市',
				'3720'=>'阜阳市',
				'3722'=>'亳州市',
				'3740'=>'宿州市',
				'3750'=>'滁州市',
				'3760'=>'六安市',
				'3771'=>'宣城市',
				'3781'=>'巢湖市',
				'3790'=>'池州市',
				'3910'=>'福州市',
				'3930'=>'厦门市',
				'3940'=>'莆田市',
				'3950'=>'三明市',
				'3970'=>'泉州市',
				'3990'=>'漳州市',
				'4010'=>'南平市',
				'4030'=>'宁德市',
				'4050'=>'龙岩市',
				'4210'=>'南昌市',
				'4220'=>'景德镇市',
				'4230'=>'萍乡市',
				'4240'=>'九江市',
				'4260'=>'新余市',
				'4270'=>'鹰潭市',
				'4280'=>'赣州市',
				'4310'=>'宜春市',
				'4330'=>'上饶市',
				'4350'=>'吉安市',
				'4370'=>'抚州市',
				'4510'=>'济南市',
				'4520'=>'青岛市',
				'4530'=>'淄博市',
				'4540'=>'枣庄市',
				'4550'=>'东营市',
				'4560'=>'烟台市',
				'4580'=>'潍坊市',
				'4610'=>'济宁市',
				'4630'=>'泰安市',
				'4634'=>'莱芜市',
				'4650'=>'威海市',
				'4660'=>'滨州市',
				'4680'=>'德州市',
				'4710'=>'聊城市',
				'4730'=>'临沂市',
				'4732'=>'日照市',
				'4750'=>'菏泽市',
				'4910'=>'郑州市',
				'4920'=>'开封市',
				'4930'=>'洛阳市',
				'4950'=>'平顶山市',
				'4960'=>'安阳市',
				'4970'=>'鹤壁市',
				'4980'=>'新乡市',
				'5010'=>'焦作市',
				'5020'=>'濮阳市',
				'5030'=>'许昌市',
				'5040'=>'漯河市',
				'5050'=>'三门峡市',
				'5060'=>'商丘市',
				'5080'=>'周口市',
				'5110'=>'驻马店市',
				'5130'=>'南阳市',
				'5150'=>'信阳市',
				'5210'=>'武汉市',
				'5220'=>'黄石市',
				'5230'=>'十堰市',
				'5260'=>'宜昌市',
				'5280'=>'襄樊市',
				'5286'=>'随州市',
				'5310'=>'鄂州市',
				'5320'=>'荆门市',
				'5330'=>'黄冈市',
				'5350'=>'孝感市',
				'5360'=>'咸宁市',
				'5370'=>'荆州市',
				'5410'=>'恩施州',
				'5510'=>'长沙市',
				'5520'=>'株州市',
				'5530'=>'湘潭市',
				'5540'=>'衡阳市',
				'5550'=>'邵阳市',
				'5570'=>'岳阳市',
				'5580'=>'常德市',
				'5590'=>'张家界市',
				'5610'=>'益阳市',
				'5620'=>'娄底市',
				'5630'=>'郴州市',
				'5650'=>'永州市',
				'5670'=>'怀化市',
				'5690'=>'吉首市',
				'5810'=>'广州市',
				'5820'=>'韶关市',
				'5840'=>'深圳市',
				'5850'=>'珠海市',
				'5860'=>'汕头市',
				'5865'=>'揭阳市',
				'5869'=>'潮州市',
				'5880'=>'佛山市',
				'5890'=>'江门市',
				'5910'=>'湛江市',
				'5920'=>'茂名市',
				'5930'=>'肇庆市',
				'5937'=>'云浮市',
				'5950'=>'惠州市',
				'5960'=>'梅州市',
				'5970'=>'汕尾市',
				'5980'=>'河源市',
				'5990'=>'阳江市',
				'6010'=>'清远市',
				'6020'=>'东莞市',
				'6030'=>'中山市',
				'6110'=>'南宁市',
				'6128'=>'崇左市',
				'6140'=>'柳州市',
				'6155'=>'来宾市',
				'6170'=>'桂林市',
				'6210'=>'梧州市',
				'6225'=>'贺州市',
				'6230'=>'北海市',
				'6240'=>'玉林市',
				'6242'=>'贵港市',
				'6261'=>'百色市',
				'6281'=>'河池市',
				'6311'=>'钦州市',
				'6330'=>'防城港市',
				'6410'=>'海口市',
				'6420'=>'三亚市',
				'6510'=>'成都市',
				'6530'=>'重庆市',
				'6550'=>'自贡市',
				'6560'=>'攀枝花市',
				'6570'=>'泸州市',
				'6580'=>'德阳市',
				'6590'=>'绵阳市',
				'6610'=>'广元市',
				'6620'=>'遂宁市',
				'6630'=>'内江市',
				'6636'=>'资阳市',
				'6650'=>'乐山市',
				'6652'=>'眉山市',
				'6670'=>'万州区',
				'6690'=>'涪陵区',
				'6710'=>'宜宾市',
				'6730'=>'南充市',
				'6737'=>'广安市',
				'6750'=>'达州市',
				'6758'=>'巴中市',
				'6770'=>'雅安市',
				'6790'=>'阿坝藏族羌族自治州',
				'6810'=>'甘孜藏族自治州',
				'6840'=>'凉山彝族自治州',
				'6870'=>'黔江区',
				'7010'=>'贵阳市',
				'7020'=>'六盘水市',
				'7030'=>'遵义市',
				'7050'=>'铜仁地区',
				'7070'=>'黔西南州',
				'7090'=>'毕节地区',
				'7110'=>'安顺市',
				'7130'=>'黔东南州',
				'7150'=>'黔南州',
				'7310'=>'昆明市',
				'7340'=>'昭通市',
				'7360'=>'曲靖市',
				'7380'=>'楚雄市',
				'7410'=>'玉溪市',
				'7430'=>'红河哈尼族彝族自治州',
				'7450'=>'文山壮族苗族自治州',
				'7470'=>'思茅市',
				'7490'=>'西双版纳傣族自治州',
				'7510'=>'大理白族自治州',
				'7530'=>'保山市',
				'7540'=>'德宏傣族景颇族自治州',
				'7550'=>'丽江市',
				'7560'=>'怒江傈僳族自治州',
				'7570'=>'迪庆藏族自治州',
				'7580'=>'临沧市',
				'7700'=>'拉萨市',
				'7720'=>'昌都地区',
				'7740'=>'山南地区',
				'7760'=>'日喀则地区',
				'7790'=>'那曲地区',
				'7811'=>'阿里地区',
				'7830'=>'林芝地区',
				'7910'=>'西安市',
				'7920'=>'铜川市',
				'7930'=>'宝鸡市',
				'7950'=>'咸阳市',
				'7970'=>'渭南市',
				'7990'=>'汉中市',
				'8010'=>'安康市',
				'8030'=>'商洛市',
				'8040'=>'延安市',
				'8060'=>'榆林市',
				'8210'=>'兰州市',
				'8220'=>'嘉峪关市',
				'8230'=>'金昌市',
				'8240'=>'白银市',
				'8250'=>'天水市',
				'8260'=>'酒泉市',
				'8270'=>'张掖市',
				'8280'=>'武威市',
				'8290'=>'定西市',
				'8310'=>'陇南市',
				'8330'=>'平凉市',
				'8340'=>'庆阳市',
				'8360'=>'临夏州',
				'8380'=>'甘南州',
				'8510'=>'西宁市',
				'8520'=>'海东地区',
				'8540'=>'海北藏族自治州',
				'8550'=>'黄南藏族自治州',
				'8560'=>'海南藏族自治州',
				'8570'=>'果洛藏族自治州',
				'8580'=>'玉树藏族自治州',
				'8590'=>'海西蒙古族藏族自治州',
				'8710'=>'银川市',
				'8720'=>'石嘴山市',
				'8731'=>'吴忠市',
				'8733'=>'中卫市',
				'8741'=>'固原市',
				'8810'=>'乌鲁木齐市',
				'8820'=>'克拉玛依市',
				'8830'=>'吐鲁番市',
				'8840'=>'哈密市',
				'8844'=>'阿勒泰地区',
				'8850'=>'昌吉回族自治州',
				'8870'=>'博尔塔拉蒙古自治州',
				'8880'=>'巴音郭楞蒙古自治州',
				'8910'=>'阿克苏地区',
				'8930'=>'克孜勒苏柯尔克孜自治州',
				'8940'=>'喀什地区',
				'8960'=>'和田地区',
				'8980'=>'伊犁哈萨克自治州',
				'9010'=>'塔城地区',
				'9020'=>'阿勒泰地区',
				'9028'=>'石河子市',
				);
		return $cityCodes;	
	}
	
	
	
}