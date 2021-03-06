<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('no3/common/header'); ?>

    <body>
        <script id="headmodel1" type="text/html" >
        <tr>
            <th class="center">userID</th>
            <th>帐号</th>
            <th>游戏</th>
            <th>订单号</th>
            <th>兑换物品</th>
            <th>兑换数目</th>
            <th>消耗兑换券</th>
             <th>开始兑换券</th>
            <th class="hidden-480">结束兑换券</th>
            <th>兑换状态</th>
            <th><i class="icon-time bigger-110 hidden-480"></i>记录时间</th>
        </tr>
    </script>

    <script id="datamodel1" type="text/html" >
        <tr>
            <td class="center">${userid}</td>
            <td>${account}</td>
            <td class="hidden-480">${gameid}</td>
            <td>${orderid}</td>
            <td class="hidden-480">${ goodid}</td>
            <td>1</td>
            <td class="hidden-480">${couponnumadded}</td>
            <td>${startcouponnum}</td>
            <td>${newcouponnum}</td>
            <td>已兑换</td>
            <td><i class="icon-time bigger-110 hidden-480"></i>${happentime}</td>
        </tr>
    </script>


    <?php $this->load->view('no3/common/message', $message); ?>

    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.check('main-container', 'fixed')
            } catch (e) {
            }
        </script>

        <div class="main-container-inner">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>

            <div class="sidebar" id="sidebar">
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>

                <?php $this->load->view('no3/common/nav_shortcut'); ?>

                <?php $this->load->view('no3/common/nav_left1', $systemconfig, $choose,$menucheck); ?>

                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
                </div>

                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </div>

            <div class="main-content">
                <?php $this->load->view('no3/common/nav_top', $header1); ?>

                <div class="page-content">
                    <?php $this->load->view('no3/common/nav_top1', $header2); ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->

                        <!--    <?php $this->load->view('no3/common/nav_top2', $header3); ?>  -->

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 widget-container-span">
                                    <div class="widget-box">
                                        <div class="widget-header header-color-blue2">
                                            <h5><i class="icon-arrow-left"></i>玩家兑换记录  <!--游戏选择：<label id="mycurrentgameid">全部（10000）</label>--></h5>

                                            <div class="widget-toolbar">
                                                <a href="#" data-action="collapse">
                                                    <i class="1 icon-chevron-up bigger-125"></i>
                                                </a>
                                            </div>
 
                                        </div>




                                        <div class="widget-toolbox padding-8 clearfix">
                                            
                                                                
                                            
                                            <div class="widget-toolbar no-border pull-left" style="width:150px;height:32px;"  >
                                                  <select class="zsh-select form-control"  id="form-field-select-3" data-placeholder="Choose a game..." style="height:32px;width:130px;">
                                                     <option value="1">全部</option>
                                                     <option value="2">话费</option>
                                                     <option value="3">实物</option>
                                                  </select>
                                            </div>
                                            
                                           <div class="widget-toolbar no-border pull-left" style="width:150px;height:32px;margin-left:-25px;">
                                                  <select class="zsh-select form-control"  id="form-field-select-4" data-placeholder="Choose a game..." style="height:32px;width:130px;">
                                                     <option value="1">全部</option>
                                                     <option value="2">审核中</option>
                                                     <option value="3">已兑换</option>
                                                  </select>
                                            </div>
                                          
                                            <input type="text" id="userid1"   placeholder="用户ID"   class="col-xs-10 col-sm-2" style = "margin-left:0px;height:30px;width:120px;"/>
     
                                            <input class=" date-picker col-xs-10 col-sm-2" id="id_date_picker_1"  placeholder="起始时间" type="text" data-date-format="yyyy-mm-dd" style = "margin-left:5px;height:30px;width:100px;"  />

                                            <div class="input-group bootstrap-timepicker" style="float:left;">
                                            <input id="id_time_picker_1" type="text" class="form-control col-xs-10 col-sm-2" style = "height:30px;width:100px;" />
                                            </div>

                                            <span class="input-group-addon col-xs-10 col-sm-2" style = "height:30px;width:60px;">
                                                <i class="icon-calendar bigger-110  zshdate1" style="cursor:pointer;"></i>
                                                <i class="icon-time bigger-110 zshtime1" style="cursor:pointer;"></i>
                                            </span>


                                            <input class=" date-picker col-xs-10 col-sm-2" id="id_date_picker_2"  placeholder="终止时间" type="text" data-date-format="yyyy-mm-dd" style = "margin-left:5px;height:30px;width:100px;"  />

                                            <div class="input-group bootstrap-timepicker" style="float:left;">
                                            <input id="id_time_picker_2" type="text" class="form-control col-xs-10 col-sm-2" style = "height:30px;width:100px;" />
                                            </div>

                                            <span class="input-group-addon col-xs-10 col-sm-2" style = "height:30px;width:60px;">
                                                <i class="icon-calendar bigger-110 zshdate2" style="cursor:pointer;"></i>
                                                <i class="icon-time bigger-110 zshtime2" style="cursor:pointer;"></i>
                                            </span>
                                              
    

                                             <button onclick="javascript:reset()" class="btn btn-xs btn-success " style="margin-top:1px;margin-left:10px;">
                                                <i class="icon-star-half icon-on-left"></i>
                                                <span class="bigger-110">重置</span>


                                            </button>

                                            <button onclick="javascript:reflesh()" class="btn btn-xs btn-success " style="margin-top:1px;">
                                                <span class="bigger-110">查询</span>

                                                <i class="icon-search icon-on-right"></i>
                                            </button>
                                            
                                            
                                            <!--
                                              <div class="widget-toolbar no-border pull-left" style="margin-top:-2px;">

                                                <button class="btn btn-xs bigger btn-success dropdown-toggle" data-toggle="dropdown">
                                                    游戏选择
                                                    <i class="icon-chevron-down icon-on-right"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                    <?php foreach ($gamelist as $myname => $myid) { ?>
                                                        <li>
                                                            <a href="javascript:changeevent('<?php echo $myid ?>','<?php echo $myname ?>')"><?php echo $myname ?></a>
                                                        </li>
                                                    <?php } ?>


                                                    <li class="divider"></li>


                                                </ul>
                                            </div>
                                            <input type="text" id="userid1"  placeholder="用户ID"   class="col-xs-10 col-sm-2" style = "margin-left:5px;height:34px;width:160px;"/>
                                            <input type="text" id="account1" placeholder="用户帐号"   class="col-xs-10 col-sm-2" style = "height:34px;width:160px;"/> 

                                            <label></label>
                                            <input type="text" id="mystarttime" placeholder="起始时间" value="<?php echo date('Y-m-d H:i:s', time() - 1 * 24 * 60 * 60) ?>" class="col-xs-10 col-sm-2" style = "height:34px;width:160px;"/> 
                                            <input type="text" id="myendtime"   placeholder="终止时间" value="<?php echo date('Y-m-d H:i:s', time()) ?>" class="col-xs-10 col-sm-2" style = "height:34px;width:160px;"/> 

                                             <button onclick="javascript:reset()" class="btn btn-xs btn-success " style="margin-top:3px;margin-left:10px;">
                                                <i class="icon-star-half icon-on-left"></i>
                                                <span class="bigger-110">重置</span>


                                            </button>

                                            <button onclick="javascript:reflesh()" class="btn btn-xs btn-success " style="margin-top:3px;">
                                                <span class="bigger-110">查询</span>

                                                <i class="icon-search icon-on-right"></i>
                                            </button>
                                            
                                            -->
                                        </div>

                                        <div class="widget-body">

                                            <div class="widget-main"  style ="padding:0;">












                                                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                                                    <thead id="targethead">
                                                         <tr>
            <th class="center">userID</th>
            <th>帐号</th>
            <th>游戏</th>
            <th>订单号</th>
            <th>兑换物品</th>
            <th>兑换数目</th>
            <th>消耗兑换券</th>
             <th>开始兑换券</th>
            <th class="hidden-480">结束兑换券</th>
            <th>兑换状态</th>
            <th><i class="icon-time bigger-110 hidden-480"></i>记录时间</th>
        </tr>
                                                    </thead>

                                                    <tbody id="targetbody">

                                                    </tbody>
                                                </table>
                                                <div class="modal-footer no-margin-top">

                                                    <div class="dataTables_info pull-left" id="sample-table-2_info">点击“获得数据”从服务器加载数据</div>
                                                    <ul class="pagination pull-right no-margin">
                                                        <li class="pageitemleft">
                                                            <a href="javascript:void">
                                                                <i class="icon-double-angle-left"></i>
                                                            </a>
                                                        </li>

                                                        <li class="active pageitemnum">
                                                            <a href="javascript:void">1</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">2</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">3</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">4</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">5</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">6</a>
                                                        </li>
                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">7</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">8</a>
                                                        </li>

                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">9</a>
                                                        </li>
                                                        <li class="pageitemnum">
                                                            <a href="javascript:void">10</a>
                                                        </li>

                                                        <li class="pageitemright">
                                                            <a href="javascript:void">
                                                                <i class="icon-double-angle-right"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>




                                                <div class="modal-body no-padding">

                                                </div>





                                            </div>


                                        </div>
                                    </div>
                                </div>



                            </div><!-- /row -->

                            <div class="hr hr32 hr-dotted"></div>

                            <div class="row">

                            </div>

                            <div class="hr hr32 hr-dotted"></div>


                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div><!-- /.main-content -->

            <div class="ace-settings-container" id="ace-settings-container">
                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="icon-cog bigger-150"></i>
                </div>

                <div class="ace-settings-box" id="ace-settings-box">
                    <div>
                        <div class="pull-left">
                            <select id="skin-colorpicker" class="hide">
                                <option data-skin="default" value="#438EB9">#438EB9</option>
                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                            </select>
                        </div>
                        <span>&nbsp; Choose Skin</span>
                    </div>

                    <div>
                        <input type="checkbox"  class="ace ace-checkbox-2" id="ace-settings-navbar"  />
                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                    </div>

                    <div>
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"  />
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                    </div>

                    <div>
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                    </div>

                    <div>
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                    </div>

                    <div>
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                        <label class="lbl" for="ace-settings-add-container">
                            Inside
                            <b>.container</b>
                        </label>
                    </div>
                </div>
            </div><!-- /#ace-settings-container -->
        </div><!-- /.main-container-inner -->

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="icon-double-angle-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->



    <!-- <![endif]-->

    <!--[if IE]>
   
    <![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='../res/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
    window.jQuery || document.write("<script src='../res/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='../res/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
    window.jQuery || document.write("<script src='../res/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        if ("ontouchend" in document)
            document.write("<script src='../res/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>
    <script src="../res/js/bootstrap.min.js"></script>
    <script src="../res/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="../res/js/excanvas.min.js"></script>
    <![endif]-->

    <script src="../res/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../res/js/jquery.ui.touch-punch.min.js"></script>
    <script src="../res/js/jquery.slimscroll.min.js"></script>
    <script src="../res/js/jquery.easy-pie-chart.min.js"></script>
    <script src="../res/js/jquery.sparkline.min.js"></script>
    <script src="../res/js/flot/jquery.flot.min.js"></script>
    <script src="../res/js/flot/jquery.flot.pie.min.js"></script>
    <script src="../res/js/flot/jquery.flot.resize.min.js"></script>
    
   

    <script src="../res/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="../res/js/date-time/bootstrap-timepicker.min.js"></script>
    <script src="../res/js/date-time/moment.min.js"></script>
    <script src="../res/js/date-time/daterangepicker.min.js"></script>
    
   
		
    <script src="../res/js/chosen.jquery.min.js"></script>
    <script src="../res/js/fuelux/fuelux.spinner.min.js"></script>
     
    <script src="../res/js/jquery.knob.min.js"></script>
    <script src="../res/js/jquery.autosize.min.js"></script>
    <script src="../res/js/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../res/js/jquery.maskedinput.min.js"></script>
    <script src="../res/js/bootstrap-tag.min.js"></script>
   
    <!-- ace scripts -->

    <script src="../res/js/jquery.dataTables.min.js"></script>
    <script src="../res/js/jquery.dataTables.bootstrap.js"></script>

    <script src="../res/js/ace-elements.min.js"></script>
    <script src="../res/js/ace.min.js"></script>
    <script src="../res/js/jspacket.js"></script>
    <!-- inline scripts related to this page -->

    <script type="text/javascript">
        var m_wupin = 1;
        var m_wupinname = "全部(1)";
        
        var m_status = 1;
        var m_statusname = "全部(1)";
     
        var beginindex = 1;
        var allcount = 0;

        var userid_back = "";
        
        var id_date_picker_1 = "";
        var id_time_picker_1 = "";
        var id_date_picker_2 = "";
        var id_time_picker_2 = "";
       
 
        var producttype1 = new Array();
       
        producttype1[0] = "兑换卡片";
        producttype1[1] = "兑换实物";
        producttype1[2] = "兑换道具";
        
        
        var gamename1 = new Array();
        
         <?php foreach ($gamelist as $myname => $myid) { ?>
             gamename1["<?php echo $myid ?>"] = "<?php echo $myname ?>";
        <?php } ?>
     

        function reset() {
            $("#id_date_picker_1").val(id_date_picker_1);
            $("#id_time_picker_1").val(id_time_picker_1);
            $("#id_date_picker_2").val(id_date_picker_2);
            $("#id_time_picker_2").val(id_time_picker_2);
            $("#userid1").val(userid_back);
        }

        function get_online_data() {
            id_date_picker_1 = $("#id_date_picker_1").val();
            id_time_picker_1 = $("#id_time_picker_1").val();
            id_date_picker_2 = $("#id_date_picker_2").val();
            id_time_picker_2 = $("#id_time_picker_2").val();
            $("#targetbody").html("");
            userid_back = $("#userid1").val();
            var packet = {
                action: 'get_online_data',
                mystarttime: $("#id_date_picker_1").val()+" "+$("#id_time_picker_1").val(),
                myendtime:   $("#id_date_picker_2").val()+" "+$("#id_time_picker_2").val(),
                userid: $("#userid1").val(),
                status:m_status,
                wupin:m_wupin,
                beginindex: (beginindex - 1) * 20
             };
            function onsuccess(data) {
                $(".pageitemnum").removeClass("hide");
                $(".pageitemleft").removeClass("disabled");
                $(".pageitemright").removeClass("disabled");
                var datax = eval("(" + data + ")");
                if(datax["status"]=="1"){
                    alert("userid或帐号至少填一个！");
                    return ;
                }
                allcount = datax["count"][0]["count"];
                
                $(".pageitemnum").each(function(e) {
                    if (e * 20 < allcount) {
                        $(this).children("a").html(e + parseInt(beginindex / 10) * 10 + 1);
                    } else {
                        $(this).addClass("hide");
                    }
                })

                for (var itemx in datax["detail"])
                {
                   // datax["detail"][itemx]["account"]  = datax["account"];
                    datax["detail"][itemx]["startcouponnum"]  = datax["detail"][itemx]["newcouponnum"] - datax["detail"][itemx]["couponnumadded"];
                    datax["detail"][itemx]["gameid"]  =   gamename1[datax["detail"][itemx]["gamecode"]];
                 }
                var msg = "总共数据：" + allcount + "条,现在是在第：" + beginindex + "页，每页20条。"
                $("#sample-table-2_info").html(msg);
                $("#targetbody").html($("#datamodel1").tmpl(datax["detail"]));
            }
            function onerrors(data) {
                // alert(objtostr(data))
            }
            jQuery.comm.sendmessage(window.location.protocol + "//" + window.location.host + "/no3/infoexchange/get_exchange_data", packet, onsuccess, onerrors);
        }

        function reflesh() {
            beginindex = 1;
            get_online_data();
        }

        reflesh();
        jQuery(function($) {
            
             $("#id_date_picker_1").val(getdate(-24*60*60));
            $("#id_date_picker_2").val(getdate(0));
            $(".pageitemnum").addClass("hide");
            $(".pageitemleft").addClass("disabled");
            $(".pageitemright").addClass("disabled");
            $(".pageitemnum").bind("click", function() {
                $(".pageitemnum").removeClass("active");
                $(this).addClass("active");
                beginindex = parseInt($(this).children("a").html());
                get_online_data();
            });

            $(".pageitemleft").bind("click", function() {
                if (!$(this).hasClass("disabled")) {
                    $(".pageitemnum").each(function(e) {
                        var tmp = parseInt($(this).children("a").html()) - 10;
                        if (tmp <= 0)
                            return;
                        $(this).children("a").html(tmp);
                    })
                }
            });

            $(".pageitemright").bind("click", function() {
                if (!$(this).hasClass("disabled")) {
                    $(".pageitemnum").each(function(e) {
                        var tmp = parseInt($(this).children("a").html()) + 10;
                        if (tmp * 20 > allcount)
                            return;
                        $(this).children("a").html(tmp);
                    });
                }
            });


            $('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function() {
                $(this).next().focus();
            });
            
              
             $('#id_date_picker_1').datepicker({autoclose:true}).on(ace.click_event, function(){
		$("#id_date_picker_1").focus();
				});
            $('#id_date_picker_2').datepicker({autoclose:true}).on(ace.click_event, function(){
		$("#id_date_picker_2").focus();
				});
                                
            $(".zshdate1").bind("click",function(){
               $("#id_date_picker_1").focus();
            });
              
            $(".zshdate2").bind("click",function(){
              $("#id_date_picker_2").focus();
            });
                                
                                  
            $('#id_time_picker_1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).on(ace.click_event, function(){
					$("#id_time_picker_1").focus();
  				});
                                
             $('#id_time_picker_2').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).on(ace.click_event, function(){
					$("#id_time_picker_2").focus();
				});  
                                
            $(".zshtime1").bind("click",function(){
              $("#id_time_picker_1").focus();
            });
              
            $(".zshtime2").bind("click",function(){
              $("#id_time_picker_2").focus();
            });
           
            
            $(".zsh-select").chosen({disable_search_threshold: 50}); 
            
            $("#form_field_select_3_chosen").addClass("col-xs-10 col-sm-2");
            
            $("#form_field_select_3_chosen").attr("style","width:150px;height:32px;");
            
            $("#form_field_select_4_chosen").addClass("col-xs-10 col-sm-2");
            
            $("#form_field_select_4_chosen").attr("style","width:150px;height:32px;");
 
        });

    </script>
</body>
</html>
