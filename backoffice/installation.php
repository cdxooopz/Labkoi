<!DOCTYPE html>
<html>
  <head>
	<?php
		  require 'installationInit.php'; 
	?>
    <meta charset="utf-8">
    <title>INSTALL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<style media="screen">
  body {
    margin-top:40px;
  }
  .stepwizard-step p {
    margin-top: 10px;
  }
  .stepwizard-row {
    display: table-row;
  }
  .stepwizard {
    display: table;
    width: 50%;
    position: relative;
  }
  .stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
  }
  .stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
  }
  .stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
  }
  .btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
  }
</style>

  </head>
  <body>
    <div class="container">
      <div class="text-center text-primary">
        <h2>LAB KOI Installation</h2>
      </div>
      <div class="progress">
        <div class="progress-bar progress-bar-aqua" id="progressbar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
          <!-- <span class="sr-only">20% Complete</span> -->
        </div>
      </div>

<div class="stepwizard col-md-offset-3">

    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-primary btn-circle" >1</a>
        <p>Step 1</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
        <p>Step 2</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
        <p>Step 3</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
        <p>Step 4</p>
      </div>
    </div>
  </div>

  <form role="form" action="" method="post">
    <div class="row setup-content" id="step-1">
      <div class="col-xs-6 col-md-offset-3">

        <div class="col-md-12">
          <h3><span class="label label-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Database config</span></h3>
          <div class="form-group">
            <label class="control-label">Host</label>
            <input id="host" maxlength="100" type="text" required="required" class="form-control" placeholder="ext. localhost" />
            <span class="text-danger">** Host Database Name </span>
          </div>
          <div class="form-group">
            <label class="control-label">Username</label>
            <input id="username"  maxlength="100" type="text" required="required" class="form-control" placeholder="ext. root" />
            <span class="text-danger">** Username Access Database</span>
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input id="password" maxlength="100" type="password" required="required" class="form-control" placeholder="ext. ****" />
            <span class="text-danger">** Password Access Database</span>
          </div>
          <div class="form-group">
            <label class="control-label">Database</label>
            <input id="database" maxlength="100" type="text" required="required" class="form-control" placeholder="ext. dbname" />
            <span class="text-danger">** Database Name</span>
          </div>
          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" id="send-step2">Next</button>
        </div>
      </div>
    </div>

    <div class="row setup-content" id="step-2">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3><span class="label label-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Project config</span></h3>
          <div class="form-group">
            <label class="control-label">WEB_PROJECT</label>
            <input id="web_project" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter WEB_PROJECT" />
            <span class="text-danger">** Website Project Name</span>
          </div>
          <div class="form-group">
            <label class="control-label">DB_PREFIX</label>
            <input id="db_prefix"  maxlength="100" type="text" required="required" class="form-control" placeholder="ext. db_" />
            <span class="text-danger">** Prefix Table name</span>
          </div>
          <div class="form-group">
            <label class="control-label">DB_VIEW</label>
            <input id="db_view" maxlength="100" type="text" required="required" class="form-control" placeholder="ext. view_" />
            <span class="text-danger">** Prefix Table View</span>
          </div>

          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" id="send-step1">Next</button>
        </div>
      </div>
    </div>

    <div class="row setup-content" id="step-3">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3><span class="label label-primary"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> Database status</span></h3>

          <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Import has been successfully finished, 18 queries executed.</div>

          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" id="send-step3">Next</button>
        </div>
      </div>
    </div>

    <div class="row setup-content" id="step-4">
      <div class="col-xs-6 col-md-offset-3">
        <div class="col-md-12">
          <h3><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Summary</h3>
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td>WEB_PROJECT :</td>
                <td id="show_WEB_PROJECT">Example</td>
              </tr>
              <tr>
                <td>DB_PREFIX :</td>
                <td id="show_DB_PREFIX">Example</td>
              </tr>
              <tr>
                <td>DB_VIEW :</td>
                <td id="show_DB_VIEW">Example</td>
              </tr>
              <tr>
                <td>Base_url :</td>
                <td id="show_Base_url">Example</td>
              </tr>
              <tr>
                <td>Host :</td>
                <td id="show_Host">Example</td>
              </tr>
              <tr>
                <td>Username :</td>
                <td id="show_Username">Example</td>
              </tr>
              <tr>
                <td>Password :</td>
                <td id="show_Password">Example</td>
              </tr>
              <tr>
                <td>Database :</td>
                <td id="show_Database">Example</td>
              </tr>
              <tr>
                <td>Account Usename :</td>
                <td id="show_Account_Usename">Example</td>
              </tr>
              <tr>
                <td>Account Password :</td>
                <td id="show_Account_Password">Example</td>
              </tr>


            </table>

          </div>

          <div class="col-md-12">

            <button class="btn btn-success col-md-12" type="button" id="send-step4">Success create project</button>

          </div>

        </div>
      </div>
    </div>
  </form>

</div>
  </body>
</html>
<script>

$(document).on('click', '#send-step4', function(){
	window.location.replace('login/')
})
$(document).on('click', '#send-step3', function(){
	$.ajax({
		url: 'installationInit.php?Mode=ThirdStep',
		dataType: 'text',
	})
	.done(function(result){
		if(result.STATUS == 'COMPLETE') console.log('confirm')
		else
		{
		alert(result);
		}
		console.log(result)
		$('#show_WEB_PROJECT').html(result.DATA.WEB_PROJECT)
		$('#show_DB_VIEW').html(result.DATA.DB_VIEW)
		$('#show_DB_PREFIX').html(result.DATA.DB_PREFIX)
		$('#show_Base_url').html(result.DATA.BASE_URL)
		$('#show_Host').html(result.DATA.host)
		$('#show_Username').html(result.DATA.user)
		$('#show_Password').html(result.DATA.password)
		$('#show_Database').html(result.DATA.dbname)
		$('#show_Account_Usename').html(result.DATA.admin)
		$('#show_Account_Password').html(result.DATA.adminPassword)
		
	})
})
$(document).on('click', '#send-step2', function(){
	var host = $('#host').val()
	var username = $('#username').val()
	var password = $('#password').val()
	var database = $('#database').val()
	$.ajax({
		url: 'installationInit.php?Mode=SecondStep',
		data: {
			'host' : host,
			'username' : username,
			'password' : password,
			'database' : database
		},
		type: 'POST',
		dataType: 'text',
	})
	.done(function(result){
		if(result.STATUS == 'COMPLETE') console.log('confirm')
		else
		{
		alert(result);
		}
	})
})
$(document).on('click', '#send-step1', function(){
	var web_project = $('#web_project').val()
	var db_prefix = $('#db_prefix').val()
	var db_view = $('#db_view').val()
	var base_url = $('#base_url').val()
	$.ajax({
		url: 'installationInit.php?Mode=FirstStep',
		data: {
			'web_project' : web_project,
			'db_prefix' : db_prefix,
			'db_view' : db_view,
			'base_url' : base_url
		},
		type: 'POST',
		dataType: 'text',
	})
	.done(function(result){
		if(result.STATUS == 'COMPLETE') console.log('confirm')
		else
		{
		alert(result);
		}
	})
})

$(document).ready(function () {
var navListItems = $('div.setup-panel div a'),
      allWells = $('.setup-content'),
      allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
  e.preventDefault();
  var $target = $($(this).attr('href')),
          $item = $(this);

  if (!$item.hasClass('disabled')) {
      navListItems.removeClass('btn-primary').addClass('btn-default');
      $item.addClass('btn-primary');
      allWells.hide();
      $target.show();
      $target.find('input:eq(0)').focus();
  }
});

allNextBtn.click(function(){
  var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url']"),
      isValid = true;


  $(".form-group").removeClass("has-error");
  for(var i=0; i<curInputs.length; i++){
      if (!curInputs[i].validity.valid){
          isValid = false;
          $(curInputs[i]).closest(".form-group").addClass("has-error");
      }
  }

  if (isValid){
    nextStepWizard.removeAttr('disabled').trigger('click');
    var p = $('#progressbar').attr('aria-valuenow');
    var rs = parseInt(p) + 25;

    $('#progressbar').attr('aria-valuenow',rs).css('width', rs+'%');
  }

});

$('div.setup-panel div a.btn-primary').trigger('click');
});

</script>
