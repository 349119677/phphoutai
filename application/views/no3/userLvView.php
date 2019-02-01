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
                                        <form
                                            action="<?php echo site_url('no3/userLv/toAdd');?>"
                                            style="float: left;">
                                            <button class="btn btn-xs btn-success "
                                                    style="margin-top: 3px;">
                                                <span class="bigger-110">新增等级</span>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main" style="padding: 0;">
                                            <table id="sample-table-2"
                                                   class="table table-striped table-bordered table-hover">
                                                <thead id="targethead">
                                                <tr>
                                                    <th>等级名称</th>
                                                    <th>晋升条件</th>
                                                    <th>用户数</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($userLvList as $v){ ?>
                                                    <tr>
                                                        <td><?php echo $v['name']; ?></td>
                                                        <td><?php echo $v['upPrice']; ?></td>
                                                        <td><?php echo $v['userNum']; ?></td>
                                                        <td>
                                                            <a href="<?php echo site_url('no3/userLv/toEdit') . "?id=" . $v['id'] . "&name=" . $v['name'] . "&upPrice=" . $v['upPrice'] . "&templateId=" . $v['templateId'] . "&note=" . $v['note']; ?>">编辑</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>


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