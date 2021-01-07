<head>
  <title>Register Page</title>
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
 Sign Up New Account     
    </div>
    </h2>

    <?php
     if(@$_GET['Invalid']==true)
     {
    ?>
        <div class="ui red message"><?php echo $_GET['Invalid'] ?></div>
    <?php
     }
    ?>
    <?php
     if(@$_GET['Exist']==true)
     {
    ?>
        <div class="ui red message"><?php echo $_GET['Exist'] ?></div>
    <?php
     }
    ?>
    <?php
     if(@$_GET['Empty']==true)
     {
    ?>
        <div class="ui red message"><?php echo $_GET['Empty'] ?></div>
    <?php
     }
    ?>
    <form action="scripts/registration.php" method="post" class="ui large form">
      <div class="ui stacked secondary  segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="envelope icon"></i>
            <input type="text" name="email" placeholder="E-Mail">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="address card icon"></i>
            <input type="text" name="name" placeholder="Name">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="address card icon"></i>
            <input type="text" name="lastname" placeholder="Last Name">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="phone icon"></i>
            <input type="text" name="phone" placeholder="Phone Number">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="suitcase icon"></i>
            <input type="text" name="companyName" placeholder="Company Name">
          </div>
        </div>
        <button class="ui fluid large teal submit button" name="Register">Sign Up</button>
      </div>
      <div class="ui error message"></div>
    </form>
    <div class="ui message">
      Already have an account?<a href="http://localhost:8080/Waiting-for-Shipment-ApiF/login.php"> Sign in</a>
    </div>
  </div>
</div>
