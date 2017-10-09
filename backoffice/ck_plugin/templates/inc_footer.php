	<!-- Footer -->
		<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <?=date('l, F m, Y - H:i:s');?>
        </div>
        <strong>Copyright &copy; 2016 - 2017 <a href="http://orange-thailand.com/">Orange Technology Solution</a>.</strong> All rights reserved.
      </footer>

	<!-- /footer -->

    <div class="loading">
                  <i class="fa fa-spinner fa-spin fa-5x" style="position: fixed;left: 50%;top: 50%;color: whitesmoke;
"></i>
<!--		<img src="<?=BASE_URL;?>backoffice/entity/html/images/loading.gif" style="position:absolute;left:45%;top:45%; z-index:9999"/>-->
</div>
<div id="protectClick" style="width:100%;height:100%;position: fixed;z-index: 10000000000000000;top: 0px;left: 0px;"></div>
<!-- DATA TABES SCRIPT -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
<!--     <script src='<?=BASE_URL;?>backoffice/entity/html/plugins/fastclick/fastclick.min.js'></script> -->
	<script src="<?=BASE_URL;?>backoffice/entity/html/dist/js/app.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/parsley/dist/parsley.js"></script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>
    <!-- jQuery -->
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/moment/min/moment.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>backoffice/entity/html/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" language="javascript" src="<?=BASE_URL;?>backoffice/HTML/Entity/JS/<?=$jsCSSPath;?>.js"></script>
    <script src="<?=BASE_URL;?>backoffice/entity/html/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<script type="text/javascript">
      $(function () {
      });
	$('#protectClick').hide();
    </script>
    <!-- Bootstrap -->

    <!-- Theme Javascript -->
    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core    
           // Core.init();

            // Init Theme Core    
            //Demo.init();

            // Custom page animation
            setTimeout(function() {
                $('.custom-nav-animation li').each(function(i, e) {
                    var This = $(this);
                    var timer = setTimeout(function() {
                        This.addClass('animated animated-short zoomIn');
                    }, 50 * i);
                });
            }, 500);


            $('.animation-nav').click(function() {
                $('.animation-nav').removeClass('btn-primary').addClass('btn-default');
                $(this).addClass('btn-primary');
            });

            // Form switcher nav
            var formSwitches = $('.admin-form-list a');

            formSwitches.on('click', function() {
                formSwitches.removeClass('item-active');
                $(this).addClass('item-active')

                if ($(this).attr('href') === "#contact3") {
                    setTimeout(function() {
                        initialize();
                    },100);
                }

            });



        });
    </script>
		<!-- console -->
		<?php
			if(IS_SPADMIN)
			{
		?>
		<div id="showingConsole" style="
		    position: fixed;
		    top: 0px;
		    right: -500px;
		    z-index: 10000000;
		    width: 500px;
		    height: 100%;
		    background-color: rgba(100,100,100,0.4);
		    color: white;">
			<button style="position: relative;top: 0px;left: -34px;color: black;" onclick="showConsole()"><i class="fa fa-coffee"></i></button>
			<input id="status" type="hidden" value="A">
			<iframe name="@Alert" id="@Alert" height="70%" width="100%"  frameborder="1" style="border: 1px solid darkgray;"></iframe>  
			<div style="width: 100%; height: 30%; padding: 10px; overflow: scroll">
				<pre>$_SESSION['LOGIN']<?php print_r($_SESSION['LOGIN'])?></pre>
			</div>
		</div>
		<script>
			function showConsole()
			{
				if(!!$('#status').val())
				{
					$('#status').val('');
					$('#showingConsole').css('right','0px');
					$('#showingConsole').css('transition','all 0.5s ease');
				}
				else
				{
					$('#status').val('A');
					$('#showingConsole').css('right','-500px');
					$('#showingConsole').css('transition','all 0.5s ease');
				}
				
			}
		</script>
		
		<?php
			}
		?>
		<!-- End console -->
