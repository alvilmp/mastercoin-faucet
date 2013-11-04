<?php include("header.php"); ?>
      
<!-- GitHub callback -->

<?php
  require_once("inc/config.php");
  require_once("inc/security.php");  
  require_once("inc/validator.php");
  require_once("inc/GitHubConnector.php");
  require_once("inc/SqlConnector.php");
        
  $valid = isValidRequest("github");
        
  // Cleanup session
  unregisterReferrer();
  unregisterUid();
      
  // Results: valid, notqualified, alreadyclaimed, error
  $result = "STATE_ERROR";
  
  if($valid)
  {
    $connector = new GitHubConnector($gitClientId, $gitClientSecret, $gitRedirectUrl);
    $connector->authenticate($_GET["code"]);
    $user = $connector->getUserDetails();
    $repos = $connector->getRepos();
	
    if($user)
    {
      $username = $user["login"];
      $identifier = $user["id"];
      $linkkarma = $user["link_karma"];
      
      if(isQualifiedGitHub($user, $repos))
      {
        $sql = new SqlConnector($sqlHost, $sqlUsername, $sqlPassword, $sqlDatabase);            
        $reward = $sql->lookupReward($identifier, "github");
                              
        if($reward)
        {
          $result = "STATE_ALREADY_CLAIMED";
          
          $txtimestamp = date("F j, Y", strtotime($reward->timestamp));
          $txid = $reward->txid;
        }
        else if($sql->wasSuccess())
        {
          $formid = generateUid();
          $reserved = $sql->registerFormId($formid, $identifier, "github");

          if($reserved)
          {
            $result = "STATE_VALID";
          }
        }
      }
      else
      {
        $result = "STATE_NOT_QUALIFIED";
      }
    }
  }
      
  if($result == "STATE_VALID")
  { ?>
  
    <div class="alert alert-success">
      <strong>Well done!</strong> Welcome back from <strong>GitHub</strong>, <?php echo $username; ?>.
    </div>
    
    <span class="description">
      <p>...</p>      
      <p>And therefore you are <strong>qualified</strong> for this reward. :)</p>
      <br />
      <p>Please enter your <strong>Mastercoin address</strong> and click <strong>submit</strong> to claim your bounty:</p>
    </span>
    
    <form class="navbar-form navbar-left" role="form" action="/claim" method="post">
      <div class="form-group">
        <input name="address" type="text" class="form-control" placeholder="Your address" style="width: 400px;" 
		autofocus required>          
      </div>
      <input name="formid" type="hidden" value="<?php echo $formid; ?>">
      <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <br /><br /><br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>
    
  <?php } else if($result == "STATE_NOT_QUALIFIED") { ?>
  
    <div class="alert alert-info">
      <strong>Too bad.</strong> Sorry, <?php echo $username; ?>...
    </div>
    
    <span class="description">
      <p>Not qualified... :(</p>
      <p>The requirement serves as protection against abuse, so we are able to give out as much free MCS as 
      possible.</p>
      <p>Please understand our position and we hope you <strong>come back</strong> later when you gained enough.</p>
    </span>

    <br /><br /><br />
    <p><a href="/"><strong>Go back</strong></a> to the frontpage.</p>
  
  <?php } else if($result == "STATE_ALREADY_CLAIMED") { ?>
  
    <div class="alert alert-warning">
      <strong>Hmm...!</strong> You already claimed this reward.
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
    <p>If you are certain that you never claimed this reward, please contact us via 
	<a href="mailto:dexx@bitwatch.co"><strong>email</strong></a>.</p>
          
    <br /><br /><br />
    <p><a href="/"><strong>Go back</strong></a> to the frontpage.</p>
    
  <?php } else { ?>
  
    <div class="alert alert-danger">
      <strong>Oh noes!</strong> There seems to be a problem.. :(
    </div>
    
    <span class="description">  
      <p>There are several reasons why you might see this.</p>
      <p>For example you declined the authorisation or you refreshed this website.</p>
      <p>You can <a href="/github-intro"><strong>click here</strong></a> to start the authentication via 
	  <strong>GitHub</strong> again.</p>
      <p>If you think there shouldn't be an error, please contact us via <a href="mailto:dexx@bitwatch.co">
	  <strong>email</strong></a>.</p>
    </span>
    
    <br /><br /><br />
    <p>Or <a href="/"><strong>go back</strong></a> to the frontpage.</p>

<?php
  }
?>

<!-- /GitHub callback -->
      
<?php include("footer.php"); ?>