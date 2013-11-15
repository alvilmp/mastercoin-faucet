<?php
  include("header.php");
  include("inc/state_facebook.php");
?>
      
<!-- Facebook callback -->

  <?php if($result == "STATE_VALID") { ?>
  
    <div class="alert alert-success">
      <strong>Well done!</strong> Welcome back from <strong>Facebook</strong>, <?php echo $name; ?>.
    </div>
	
    <span class="description">
      <p>You are <strong>qualified</strong> for this reward. :)</p>
    </span>
	
	<br />
    <p>Please enter your <strong>Mastercoin address</strong> and click <strong>submit</strong> to claim your bounty:</p>
      
    <form class="navbar-form navbar-left" role="form" action="/claim" method="post">
      <div class="form-group">
        <input name="address" type="text" class="form-control" placeholder="Your address" style="width: 400px;" 
		autofocus required>          
      </div>
      <input name="state" type="hidden" value="<?php echo $formid; ?>">
      <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <br /><br /><br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>
    
  <?php } else if($result == "STATE_INVALID_ADDRESS") { ?>
  
    <div class="alert alert-warning">
      <strong>Invalid address.</strong> 
    </div>
          
    <span class="description">  
      <p>It looks like you already have claimed your reward on <strong><?php echo $txtimestamp; ?></strong>.</p>
      <p>You can lookup the transaction and all further details on:</p>
    </span>
	
    <ul>
      <li><a href="http://mastercoin-explorer.com/transactions/<?php echo $txid; ?>" target="_blank">
	  <strong>mastercoin-explorer.com</strong></a></li>
      <li><a href="https://masterchest.info/lookuptx.aspx?txid=<?php echo $txid; ?>" target="_blank">
	  <strong>masterchest.info</strong></a></li>
    </ul>
    <p>If you are certain that you never claimed this reward, please contact us via <a href="mailto:dexx@bitwatch.co">
	<strong>email</strong></a>.</p>
          
    <br /><br /><br />
    <p><a href="/"><strong>Go back</strong></a> to the frontpage.</p>
  
  <?php } else if($result == "STATE_SESSION_ERROR") { ?>
  
    <div class="alert alert-warning">
      <strong>Hmm..!</strong> There is a problem with your session.
    </div>
	
    <span class="description">
      <p>There are several reasons why you might see this.</p>
      <p>Did you refresh this page or are your cookies disabled?</p>
      <p>You can <a href="/facebook-intro"><strong>click here</strong></a> to start the authentication via 
      <strong>Facebook</strong> again.</p>
      <p>If you think there shouldn't be an error, please contact us via <a href="mailto:dexx@bitwatch.co">
      <strong>email</strong></a>.</p>
    </span>
	
    <br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>
  
  
  <?php } else { ?>
  
    <div class="alert alert-danger">
      <strong>Oh noes!</strong> The authentication via Facebook failed.. :(
    </div>
    
    <span class="description">
      <p>Did you decline the authorisation?</p>
      <p>You can <a href="/facebook-intro"><strong>click here</strong></a> to start the authentication via 
	  <strong>Facebook</strong> again.</p>
      <p>If you think there shouldn't be an error, please contact us via <a href="mailto:dexx@bitwatch.co">
	  <strong>email</strong></a>.</p>
    </span>
    
    <br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>

  <?php } ?>


<!-- /Facebook callback -->

<?php include("footer.php"); ?>