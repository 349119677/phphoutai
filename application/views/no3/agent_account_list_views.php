<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('no3/common/header'); ?>

    <body>
    <?php $this->load->view('no3/common/message'); ?>

    <div class="main-container" id="main-container">
		<script type="text/javascript">
            try {
                ace.settings.check('main-container', 'fixed')
            } catch (e) {
            }
        </script>

		<div class="main-container-inner">
			<a class="menu-toggler" id="menu-toggler" href="#"> <span
				class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">
				<script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>

                <?php $this->load->view('no3/common/nav_shortcut'); ?>

                <?php $this->load->view('no3/common/nav_left1'); ?>

                <div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"
						data-icon1="icon-double-angle-left"
						data-icon2="icon-double-angle-right"></i>
				</div>

				<script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
			</div>

			<div class="main-content">
                <?php $this->load->view('no3/common/nav_top'); ?>

                <div class="page-content">
                <?php if($this->session->flashdata('success')){ ?><div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div><?php } ?>
                	<?php if($this->session->flashdata('error')){ ?><div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div><?php } ?>
					
					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-sm-12 widget-container-span">
									<div class="widget-box">
										<div class="widget-toolbox padding-8 clearfix">
                                            <a href="<?php echo site_url('no3/agentAccount/toAdd'); ?>" class="btn btn-success">添加代理帐号</a>
                                        </div>
										<div class="widget-body">
											<div class="widget-main" style="padding: 0;">
												<table id="sample-table-2"
													class="table table-striped table-bordered table-hover">
													<thead id="targethead">
														<tr>
															<th class="center">ID</th>
															<th>代理帐号</th>
															<th>可访问域名</th>
															<th>状态</th>
															<th>操作</th>
														</tr>
													</thead>
													<tbody>
													<?php foreach ($agent_account_list as $v){ ?>
														<tr>
															<td><?php echo $v['id']; ?></td>
															<td><?php echo $v['account']; ?></td>
															<td><?php echo $v['host']; ?></td>
															<td><?php echo $v['status'] ? '启用' : '关闭'; ?></td>
															<td>
																<a href="<?php echo site_url('no3/agentAccount/toEdit/'.$v['id']); ?>">修改</a>
																<a href="<?php echo site_url('no3/agentAccount/del/'.$v['id']); ?>">删除</a>
															</td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
												<!-- <div class="modal-footer no-margin-top">

													<div class="dataTables_info pull-left"
														id="sample-table-2_info">点击“获得数据”从服务器加载数据</div>
													<ul class="pagination pull-right no-margin">
														<li class="pageitemleft"><a href="javascript:void"> <i
																class="icon-double-angle-left"></i>
														</a></li>

														<li class="active pageitemnum"><a href="javascript:void">1</a>
														</li>

														<li class="pageitemnum"><a href="javascript:void">2</a></li>

														<li class="pageitemnum"><a href="javascript:void">3</a></li>

														<li class="pageitemnum"><a href="javascript:void">4</a></li>

														<li class="pageitemnum"><a href="javascript:void">5</a></li>

														<li class="pageitemnum"><a href="javascript:void">6</a></li>
														<li class="pageitemnum"><a href="javascript:void">7</a></li>

														<li class="pageitemnum"><a href="javascript:void">8</a></li>

														<li class="pageitemnum"><a href="javascript:void">9</a></li>
														<li class="pageitemnum"><a href="javascript:void">10</a></li>

														<li class="pageitemright"><a href="javascript:void"> <i
																class="icon-double-angle-right"></i>
														</a></li>
													</ul>
												</div> -->

												<div class="modal-body no-padding"></div>

											</div>


										</div>
									</div>
								</div>



							</div>


						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.page-content -->
			</div>
			<!-- /.main-content -->
			<!-- /#ace-settings-container -->
		</div>
		<!-- /.main-container-inner -->
	</div>
	<!-- /.main-container -->
	<script src="<?php echo base_url().'res/js/jquery-2.0.3.min.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/jquery-ui-1.10.3.custom.min.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/bootstrap.min.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/ace-elements.min.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/ace.min.js'; ?>"></script>	
</body>
</html>