<head>
  <title>Login Page</title>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
	<meta charset="utf-8">
	
	<style type="text/css">
		
	body > .grid {
		height: 100%;
	}
	.image {
		margin-top: -100px;
	}
	.column {
		max-width: 450px;
	}
	</style>
</head>
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui image header">
      <div class="content">
Login to Your Account      
    </div>
    </h2>

    <?php
     if(@$_GET['Empty']==true)
     {
    ?>
        <div class="ui red message"><?php echo $_GET['Empty'] ?></div>
    <?php
     }
    ?>

<?php
     if(@$_GET['Success']==true)
     {
    ?>
        <div class="ui green message"><?php echo $_GET['Success'] ?></div>
    <?php
     }
    ?>

    <?php
     if(@$_GET['Invalid']==true)
     {
    ?>
        <div class="ui red message"><?php echo $_GET['Invalid'] ?></div>
    <?php
     }
    ?>
    <form action="process.php" method="post" class="ui large form">
      <div class="ui stacked secondary  segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="E-Mail">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <button class="ui fluid large teal submit button" name="Login">Sign in</button>
      </div>
      <div class="ui error message"></div>
    </form>
    <div class="ui message">
      If you don't have an account <a href="http://localhost:8080/Waiting-for-Shipment-ApiF/register.php">Register!</a>
    </div>
  </div>
</div>
