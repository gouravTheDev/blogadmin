<!-- <div class="DCenterAll">
  <h3 class="text-center">System Admin</h3>
</div> -->
<div class="container">
  <script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
  </script>

  <?php
// phpinfo();
// echo APP_PATH,APP_DIR;
  if (isset($_GET)){
    if (isset($_GET['CreateBackup'])){
      echo '<br> <button onclick="window.history.back();">Go Back</button> <br><br>';
        if ($_GET['CreateBackup']=='DB'){
          if (isset($_GET['DB']) && strlen($_GET['DB'])>0){

            if (isset($_GET['TABLE']) && strlen($_GET['TABLE'])>0){
              $d="";$f=""; if (isset($_GET['TABLE_DATA']) && strlen($_GET['TABLE_DATA'])>0) {$d="--no-data";$f="SCHEMA_";}
              if (!file_exists('_BACKUP/DB/'.$_GET['DB'])) mkdir('_BACKUP/DB/'.$_GET['DB'], 0755, true);
              exec('mysqldump -u '.MYSQL_USER.' -p'.MYSQL_PASS.' '.$d.' --single-transaction --quick --lock-tables=false '.$_GET['DB'].' '.$_GET['TABLE'].' > _BACKUP/DB/'.$_GET['DB'].'/$(date +%F_%T)_'.$f.$_GET['TABLE'].'.sql', $output, $return);
              if($return==0) echo $f."TABLE backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo $f."TABLE backup fail,check destination folder! <br>",$return;
              // echo 'mysqldump -u '.MYSQL_USER.' -p'.MYSQL_PASS.' '.$d.' --single-transaction --quick --lock-tables=false '.$f.$_GET['DB'].' '.$_GET['TABLE'].' > _BACKUP/DB/'.$_GET['DB'].'/$(date +%F_%T)_'.$_GET['TABLE'].'.sql';
            }

            elseif (isset($_GET['SCHEMA']) && strlen($_GET['SCHEMA'])>0){
              if (!file_exists('CONTENT/DATA/SCEMA/DB')) mkdir('CONTENT/DATA/SCEMA/DB', 0755, true);
              exec('mysqldump -u '.MYSQL_USER.' -p'.MYSQL_PASS.' -d --single-transaction --quick --lock-tables=false '.$_GET['DB'].' > CONTENT/DATA/SCEMA/DB/$(date +%F_%T)_SCHEMA_'.$_GET['DB'].'.sql', $output, $return);
              if($return==0) echo "DB SCHEMA backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "DB SCHEMA backup fail,check destination folder! <br>",$return;
            }
            else {
              if (!file_exists('_BACKUP/DB')) mkdir('_BACKUP/DB', 0755, true);
              exec('mysqldump -u '.MYSQL_USER.' -p'.MYSQL_PASS.' --single-transaction --quick --lock-tables=false '.$_GET['DB'].' > _BACKUP/DB/$(date +%F_%T)_'.$_GET['DB'].'.sql', $output, $return);
              if($return==0) echo "DB backup <b>with data</b> success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "DB backup <b>with data</b> fail,check destination folder! <br>",$return;
            }

          }
        }
        elseif ($_GET['CreateBackup']=='CONFIG'){
          if (!file_exists('_BACKUP/CONFIG')) mkdir('_BACKUP/CONFIG', 0755, true); exec('tar zcf _BACKUP/CONFIG/$(date +%F_%T)_CONFIG.tar.gz CONFIG/*', $output, $return);
          if($return==0) echo "CONFIG backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "CONFIG backup fail,check destination folder! <br>";
        }
        elseif ($_GET['CreateBackup']=='CONTENT'){
          if (!file_exists('_BACKUP/CONTENT')) mkdir('_BACKUP/CONTENT', 0755, true); exec('tar zcf _BACKUP/CONTENT/$(date +%F_%T)_CONTENT.tar.gz CONTENT/*', $output, $return);
          if($return==0) echo "CONTENT backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "CONTENT backup fail,check destination folder! <br>";
        }
        elseif ($_GET['CreateBackup']=='DATA'){
          if (!file_exists('_BACKUP/DATA')) mkdir('_BACKUP/DATA', 0755, true); exec('tar zcf _BACKUP/DATA/$(date +%F_%T)_DATA.tar.gz CONTENT/DATA/*', $output, $return);
          if($return==0) echo "DATA backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "DATA backup fail,check destination folder! <br>";
        }
        elseif ($_GET['CreateBackup']=='UPLOADS'){
          if (!file_exists('_BACKUP/UPLOADS')) mkdir('_BACKUP/UPLOADS', 0755, true); exec('tar zcf _BACKUP/UPLOADS/$(date +%F_%T)_UPLOADS.tar.gz CONTENT/UPLOADS/*', $output, $return);
          if($return==0) echo "UPLOADS backup success <br>  <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "UPLOADS backup fail,check destination folder! <br>",$return;
        }
        elseif ($_GET['CreateBackup']=='USERS'){
          if (!file_exists('_BACKUP/USERS')) mkdir('_BACKUP/USERS', 0755, true); exec('tar zcf _BACKUP/USERS/$(date +%F_%T)_USERS.tar.gz CONTENT/USERS/*', $output, $return);
          if($return==0) echo "USERS backup success <br> <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else echo "USERS backup fail,check destination folder! <br>";
        }

        else {
          // code...
        }

      }
      elseif (isset($_GET['git'])){
        echo '<br> <button onclick="window.history.back();">Go Back</button> <br><br>';
        if ($_GET['git']=="init"){
          exec('git init', $initOutput, $initReturn);
          if($initReturn==0) echo "<h2> git init Success </h2> <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else  echo "<h2> git init FAILED </h2>",$initReturn;
        }
        if ($_GET['git']==="AddAll"){
          exec('git add -A', $initOutput, $initReturn);
          if($initReturn==0) echo "<h2> git All add Success </h2> <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else  echo "<h2> git All Add FAILED , Seems nothing to  Add</h2>",$initReturn;
        }
        if ($_GET['git']==="Commit"){
          if(isset($_GET['Commit']) && strlen($_GET['Commit'])>0) exec('git commit -m '.$_GET['Commit'], $initOutput, $initReturn);
          else exec('git commit -m "$(date +%F_%T)"', $initOutput, $initReturn);
          if($initReturn==0) echo "<h2> git Commit Success </h2> <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else  echo "<h2> git Commit FAILED , Seems nothing to commit</h2>",$initReturn;
        }
        if ($_GET['git']==="Push"){
          exec('git push', $initOutput, $initReturn);
          if($initReturn==0) echo "<h2> git Push Success </h2> <meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>"; else  echo "<h2> git Push FAILED </h2>",$initReturn;
        }
        if ($_GET['git']==="push" && isset($_GET['origin']) && strlen($_GET['origin'])>0){
          exec('git push origin '.$_GET['origin'], $initOutput, $initReturn);
          if($initReturn==0) {echo "<h2> Push to ".$_GET['origin']." Success </h2>"; }  else {echo "<h2> git Push FAILED </h2>",$initReturn;var_dump($initOutput);}
        }
        if ($_GET['git']==="pull" && isset($_GET['origin']) && strlen($_GET['origin'])>0){
          exec('git pull origin '.$_GET['origin'], $initOutput, $initReturn);
          if($initReturn==0) {echo "<h2> git Pull Success </h2>"; var_dump($initOutput);}  else  echo "<h2> git Pull FAILED </h2>",$initReturn;
        }
        if ($_GET['git']==="Pull"){
          exec('git pull', $initOutput, $initReturn);
          if($initReturn==0){echo "<h2> git Pull Success </h2>"; var_dump($initOutput);}  else  echo "<h2> git Pull FAILED </h2>",$initReturn;
        }
        if ($_GET['git']==="checkout" && isset($_GET['origin']) && strlen($_GET['origin'])>0){
          // exec('git commit -m "$(date +%F_%T)"', $commitOutput, $commitReturn);
          // if($commitOutput==0){
            exec('git checkout '.$_GET['origin'], $checkoutOutput, $checkoutReturn);
            if($checkoutReturn==0)echo "<h2> git checkout Success </h2>";   else  echo "<h2> git checkout FAILED </h2>",$checkoutReturn,'<br>';var_dump($checkoutReturn);
            // } else var_dump($commitOutput);
          // var_dump($commitOutput);

        }


      }
      elseif (isset($_GET['Restore'])){
        echo '<br> <button onclick="window.history.back();">Go Back</button> <br><br>';
        if ($_GET['Restore']==="DB"){
          // echo "string";//mysql -u [user] -p [database_name] < [filename].sql
          exec('mysql -u '.MYSQL_USER.' -p'.MYSQL_PASS.' '.$_GET['db'].' < '.APP_DIR.'/'.$_GET['File'] ,$checkoutOutput, $checkoutReturn);
          if($checkoutReturn==0)echo "<h2> DB Restore Success </h2>";   else  echo "<h2> DB Restore FAILED </h2>",$checkoutReturn,'<br>'; echo "<meta http-equiv='refresh' content='2;url=".$_SERVER['HTTP_REFERER']."'>";
        }

      }
      elseif (isset($_GET['BranchName']) && strlen($_GET['BranchName'])>0) {
        exec('git checkout -b '.$_GET['BranchName'], $initOutput, $initReturn);
        if($initReturn==0) {echo "<h2> Branch Created: ".$_GET['BranchName'];echo '</h2>'; }  else {echo "<h2> New Branch Creation Failed </h2>",$initReturn;var_dump($initOutput);}

      }




  elseif (isset($_GET['futurePlanForExceptionHandling'])) {
    echo '<br> <button onclick="window.history.back();">Go Back</button>  ';
  }
  else{




    exec('date', $tt, $rtn);
    if($rtn==0){

      $remoteOriginList=[];$localBranchList=[];$currentBranch='NA';
      exec('git branch -a', $output, $return);//var_dump($output);
      foreach($output as $result) {
        $tt = explode('remotes/origin/', $result);$ttt = explode(' ', $result);// echo $ttt[1],'<br>';
        if(isset($tt[1]) && strlen($tt[1])>0) array_push($remoteOriginList,$tt[1]); elseif(isset($ttt[1]) && strlen($ttt[1])>0) $currentBranch=$ttt[1]; else array_push($localBranchList,$result);
      }
      if($return==0){ // git existed
        $gitCommit="";
        $addAll="";
        $gitPush="";
        echo "<h2> Git details:</h2>";
        exec('git status', $StatusOutput, $StatusReturn);
        foreach($StatusOutput as $StatusResult) {
          echo $StatusResult,'<br>';
          if (strpos($StatusResult, 'Changes to be committed') !== false) $gitCommit="commit";
          if (strpos($StatusResult, 'Changes not staged for commit') !== false) $addAll="add";
          if (strpos($StatusResult, 'git add') !== false) $addAll="add";
          if (strpos($StatusResult, 'use "git push" to publish') !== false) $gitPush="push";
          if (strpos($StatusResult, 'nothing to commit, working tree clean') !== false && $gitPush=="") echo '<h1>&#128329; ready to leave</h1>';
        } echo '<br><br>';

        echo "<h4> Local Branch List:</h4>";  if($addAll=="add")echo '<a href="?git=AddAll">Add All</a><br>'; if($gitCommit=="commit")echo' <a href="?git=Commit">Commit</a><br>'; echo '<form> <input type="text" name="Commit" placeholder="New Commit"> <input type="hidden" name="git" value="Commit"></form>'; if($gitPush=="push")echo ' <a href="?git=Push">Push</a><br>'; echo $currentBranch.'(Current) <a href="?git=push&origin='.$currentBranch.'"> ->Push</a><br>'; foreach($localBranchList as $branch) echo $branch,'<a href="?git=checkout&origin='.$branch.'"> &#10175; Checkout</a> &nbsp; <a href="?git=push&origin='.$branch.'"> ->Push</a> <br>';
        echo '<form> <input type="text" name="BranchName" placeholder="New Branch"></form>';
        echo "<h4> Remote Branch List:</h4>"; echo '<a href="?git=Pull">Pull</a><br>'; foreach($remoteOriginList as $branch)echo  '<a href="?git=pull&origin='.$branch.'"> <-Pull </a>' ,$branch,"<br>";
      }
      else { // git init
        echo '<h2> Git init <a href="?git=init"> &#10052; </a> </h2>';
      }

    }
    else echo "No Terminal / Console access! (ask your host provider)!!";




    echo '<br><br> <h4>MYSQL_HOST: '.MYSQL_HOST.' &nbsp; MYSQL_USER: '.MYSQL_USER.'&nbsp; MYSQL_PASS: '.MYSQL_PASS.'</h4>';
    echo '<h3> DB Schema List: </h3> <h5> <a title="purge all tables of this DB" href="?DbEmpty="> &#9851; </a> MYSQL_DB1: '.MYSQL_DB_BEANSTALKFP.' <a title="New Schema Backup of this DB" href="?CreateBackup=DB&DB='.MYSQL_DB_BEANSTALKFP.'&SCHEMA=true"> + </a></h5>';
    foreach (glob('CONTENT/DATA/SCEMA/DB/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB='.MYSQL_DB_BEANSTALKFP.'"> &#10060; </a> &nbsp; ', fileNameFromPath($filename),' (',filesize($filename),' bytes)', '<a href=/'.$filename.' title="Download" download> &#8675; </a> &nbsp; <a title="Restore" href="?Restore=DB&db='.MYSQL_DB_BEANSTALKFP.'&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    $link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB_BEANSTALKFP);
    $listdbtables = array_column(mysqli_fetch_all($link->query('SHOW TABLES')),0);
    foreach($listdbtables as $result) {
    echo $result, '<a title="Schema Backup of this table" href="?CreateBackup=DB&DB='.MYSQL_DB_BEANSTALKFP.'&TABLE='.$result.'&TABLE_DATA=SCHEMA"> + </a> <br>';
    }

    echo '<br><h3> DB & Data Backup List: </h3> <h5> <a title="purge all tables of this DB" href="?DbEmpty='.fileNameFromPath($filename).'"> &#9851; </a> MYSQL_DB1: '.MYSQL_DB_BEANSTALKFP.' <a title="Backup this DB with DATA" href="?CreateBackup=DB&DB='.MYSQL_DB_BEANSTALKFP.'"> + </a></h5>';
    foreach (glob('_BACKUP/DB/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=DB&DB='.MYSQL_DB_BEANSTALKFP.'"> &#10060; </a> &nbsp; ', fileNameFromPath($filename),' (',filesize($filename),' bytes)', '<a href=/'.$filename.' title="Download" download> &#8675; </a> &nbsp; <a title="Restore" href="?Restore=DB&db='.MYSQL_DB_BEANSTALKFP.'&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    foreach($listdbtables as $result) {
    echo $result, '<a href="?CreateBackup=DB&DB='.MYSQL_DB_BEANSTALKFP.'&TABLE='.$result.'"> + </a> <br>';
    }

    echo "<br> <hr> <h3> Backed up Tables </h3>"; foreach (glob('_BACKUP/DB/'.MYSQL_DB_BEANSTALKFP.'/*.*') as $filename)  echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=Table&DB='.MYSQL_DB_BEANSTALKFP.'"> &#10060; </a> &nbsp; ', fileNameFromPath($filename),' (',filesize($filename),' bytes)', '<a href=/'.$filename.' title="Download" download> &#8675; </a> &nbsp; <a title="Restore" href="?Restore=DB&db='.MYSQL_DB_BEANSTALKFP.'&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";


    echo '<hr><br> <h3> CONFIG(folder) Backup List <a title="New Backup" href="?CreateBackup=CONFIG"> + </a> </h3>';
      foreach (glob('_BACKUP/CONFIG/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB="> &#10060; </a>',fileNameFromPath($filename),'<a href=/'.$filename.' download> &#8675; </a> (',filesize($filename),' bytes)', '<a title="Restore" href="?Restore=CONFIG&db=&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    echo '<hr><br> <h3> CONTENT(folder) Backup List <a title="New Backup" href="?CreateBackup=CONTENT"> + </a> </h3>';
      foreach (glob('_BACKUP/CONTENT/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB="> &#10060; </a>',fileNameFromPath($filename),'<a href=/'.$filename.' download> &#8675; </a> (',filesize($filename),' bytes)', '<a title="Restore" href="?Restore=CONFIG&db=&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    echo '<hr><br> <h3> DATA(folder) Backup List <a title="New Backup" href="?CreateBackup=DATA"> + </a> </h3>';
      foreach (glob('_BACKUP/DATA/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB="> &#10060; </a>',fileNameFromPath($filename),'<a href=/'.$filename.' download> &#8675; </a> (',filesize($filename),' bytes)', '<a title="Restore" href="?Restore=CONFIG&db=&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    echo '<hr><br> <h3> UPLOADS(folder) Backup List <a title="New Backup" href="?CreateBackup=UPLOADS"> + </a> </h3>';
      foreach (glob('_BACKUP/UPLOADS/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB="> &#10060; </a>',fileNameFromPath($filename),'<a href=/'.$filename.' download> &#8675; </a> (',filesize($filename),' bytes)', '<a title="Restore" href="?Restore=CONFIG&db=&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

    echo '<hr><br> <h3> USERS(folder) Backup List <a title="New Backup" href="?CreateBackup=USERS"> + </a> </h3>';
    foreach (glob('_BACKUP/USERS/*.*') as $filename) echo '<a title="Delete File" href="?DelFile='.fileNameFromPath($filename).'&Type=SCHEMA&DB="> &#10060; </a>',fileNameFromPath($filename),'<a href=/'.$filename.' download> &#8675; </a> (',filesize($filename),' bytes)', '<a title="Restore" href="?Restore=CONFIG&db=&File='.$filename.'" title="Restore"> &#9981; </a> <br>';  echo "<br>";

  }

}

?>
