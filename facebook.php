<?php
  include("header.php");
  include("inc/state_facebook.php");
?>

<!-- Facebook callback -->

  <?php if($result == "STATE_VALID") { ?>
  
    <div class="alert alert-success">
      <strong>Well done!</strong> Welcome back from <strong>Facebook</strong>, <?php echo $name; ?>.
    </div>
    
    <div class="description">
      <p>You are <strong>qualified</strong> for this reward. :)</p>
      <p>Don't forget to check out the <a href="https://www.facebook.com/groups/mastercoin/" target="_blank">
      <strong>Mastercoin group</strong></a> on Facebook.</p>
    </div>
    
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
    
  <?php } else if($result == "STATE_ALREADY_CLAIMED") { ?>
  
    <div class="alert alert-warning">
      <strong>Hmm...!</strong> You already claimed a reward.
    </div>
    
    <div class="description">
      <p>It looks like you already claimed a reward earlier.</p>
      <p>You can lookup the transaction and all further details on:</p>
    </div>
    
    <ul>
      <li><a href="http://mastercoin-explorer.com/transactions/<?php echo $txid; ?>" target="_blank">
      <strong>mastercoin-explorer.com</strong></a></li>
      <li><a href="https://masterchest.info/lookuptx.aspx?txid=<?php echo $txid; ?>" target="_blank">
      <strong>masterchest.info</strong></a></li>
      <li><a href="http://masterchain.info/simplesend.html?currency=<?php if ($curtype == 2) echo "T"; ?>MSC&tx=<?php 
      echo $txid; ?>" target="_blank"><strong>masterchain.info</strong></a></li>
      <li><a href="https://blockchain.info/tx/<?php echo $txid; ?>" target="_blank">
      <strong>blockchain.info</strong></a></li>
    </ul>
    <br />
    
    <p>If you are certain that you never claimed this reward, please contact us via <a href="mailto:faucet@bitwatch.co">
    <strong>email</strong></a>.</p>
    
    <br /><br /><br />
    <p><a href="/"><strong>Go back</strong></a> to the frontpage.</p>
  
  <?php } else if($result == "STATE_SESSION_ERROR") { ?>
  
    <div class="alert alert-warning">
      <strong>Hmm..!</strong> There is a problem with your session.
    </div>
    
    <div class="description">
      <p>There are several reasons why you might see this.</p>
      <p>Did you refresh this page or are your cookies disabled?</p>
      <p>You can <a href="/facebook-intro"><strong>click here</strong></a> to start the authentication via 
      <strong>Facebook</strong> again.</p>
      <p>If you think there shouldn't be an error, please contact us via <a href="mailto:faucet@bitwatch.co">
      <strong>email</strong></a>.</p>
    </div>
    
    <br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>
    
  <?php } else { ?>
  
    <div class="alert alert-danger">
      <strong>Oh noes!</strong> The authentication via Facebook failed.. :(
    </div>
    
    <div class="description">
      <p>Did you decline the authorisation?</p>
      <p>You can <a href="/facebook-intro"><strong>click here</strong></a> to start the authentication via 
      <strong>Facebook</strong> again.</p>
      <p>If you think there shouldn't be an error, please contact us via <a href="mailto:faucet@bitwatch.co">
      <strong>email</strong></a>.</p>
    </div>
    
    <br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>
    
  <?php } ?>
  
<!-- /Facebook callback -->

<?php include("footer.php"); ?>