<!DOCTYPE html>
<html lang="en">
<head>
    <title>LSMS Installer</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
	<div class="col-md-6 offset-md-3">
		<div class='wrapper'>
		    <header>
	            <img src="assets/images/logo.jpg" alt="Logo"/>
	            <h1 class="text-center">LSMS Auto Installer</h1>
	        </header>
	        <hr>
		    <div class="content">
		        <?php
		        if (isset($_GET['_error'])) {
		        	if ($_GET['_error'] == '1') {
		        		echo '<h4 class="text-danger">Wrong Purchase Code !</h4>';
		        	} else {
		        		echo '<h4 class="text-danger"> Unable to Connect Database, Please make sure database info is correct and try again ! </h4>';
		        	}
		        }
		        ?>
		        <form  action="step4.php" method="post">
		            <fieldset>
						<label>Envato Purchase Code <a href="#purchasecodeModal" role="button" data-toggle="modal">?</a></label>
		                <input type='text' class="form-control" name="purchasecode">
		                <label>Database Host (<span class='help-block'>e.g. localhost</span>)</label>
		                <input type='text' class="form-control" name="dbhost">
		                <label>Database Username</label>
		                <input type='text' class="form-control" name="dbuser">
		                <label>Database Password</label>
		                <input type='password' class="form-control" name="dbpass">
		                <label>Database Name</label>
		                <input type='text' class="form-control" name="dbname">
		                <button type='submit' class='btn btn-primary btn-block'>Submit</button>
		            </fieldset>
		        </form>
		    </div>
		    <hr>
		    <footer>Copyright &copy; lionCoders. All Rights Reserved.</footer>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="purchasecodeModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">How to find your purchase code</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <img src="assets/images/purchasecode.jpg">
	      </div>
	    </div>
	  </div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script>
		$(function () {
			$('form').on('submit', function (e) {
		        var isValid = true;
		        $('input[type="text"]').each(function() {
		            if ($.trim($(this).val()) == '') {
		                isValid = false;
		                $(this).css({
		                    "border": "1px solid red",
		                    "background": "#FFCECE"
		                });
		            }
		            else {
		                $(this).css({
		                    "border": "",
		                    "background": ""
		                });
		            }
		        });
		        if (isValid == false)  {
		            e.preventDefault();
		        }
	    	});
		});
	</script>
</body>
</html>