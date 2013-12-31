<!DOCTYPE html>

<?php
    $db_hostname = 'localhost';
    $db_database = 'music_lib';
    $db_username = 'root';
    $db_password = 'root';  
?>            
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" href="skin/jplayer.blue.monday.css" rel="stylesheet" />
        <style type='text/css'>
            .playMusic{
                cursor: pointer;
            }
            
        </style>
        <script type="text/javascript" src="jQuery/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var current;
                $("#jquery_jplayer_1").jPlayer({
                  ready: function () {
                    $(this).jPlayer("setMedia", {
                      //mp3:"MP3_FILES/1.mp3"
                    });
                  },
                  
                  ended: function(){
                    if (typeof current.attr("value") === 'undefined'){
                        $("div.jp-title ul li").html("No next song!");
                    }else{
                        var path = current.attr("value");
                        $(this).jPlayer("setMedia", {
                            mp3: path
                        }).jPlayer("play");
                        $("div.jp-title ul li").html(current.html());
                        current = current.next();
                    }
                  },
                  
                  swfPath: "js",
                  supplied: "mp3",
                  
                });
                
                $("div#playMusic").click(function(){
                    var path = $(this).attr("value");
                    current = $(this).next();
                    $("#jquery_jplayer_1").jPlayer("setMedia", {
                        mp3: path
                    }).jPlayer("play");
                    $("div.jp-title ul li").html($(this).html());
                });
            });
        </script>
        <title>Huy Index</title>
    </head>
    <body>
        <?php
            class User{
                public $myID;
                public $myName;
                
                public function view(){
                    return ($this->$myID . " " .$this->$myName . "<br/>");
                }
            }
            
            try{
                $conn = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->query("SET NAMES UTF8");
                
                // Prepare query
                $statement = $conn->prepare("SELECT * FROM songs");
                
                $id = '%';
                $name = '%';
                
                // Bind parameters
                $statement->bindParam(':id', $id);
                $statement->bindParam(':name', $name);
                
                // Change fetch mode to CLASS mode
                //$statement->setFetchMode(PDO::FETCH_CLASS, 'User');
                
                // Execute query
                $statement->execute();
                
                // Fetch all records
                $rows = $statement->fetchAll(PDO::FETCH_CLASS);
                
                if (count($rows)){
                    foreach ($rows as $row){
                        echo "<div id='playMusic' class='playMusic' value='$row->path'>$row->id $row->name</div>";
                    }
                }else{
                    echo "No result.";
                }
            }catch(PDOException $e){
                echo "ERROR: ". $e->getMessage();
            }
        ?>
        
        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
        <div id="jp_container_1" class="jp-audio">
          <div class="jp-type-single">
            <div class="jp-gui jp-interface">
              <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
              </ul>
              <div class="jp-progress">
                <div class="jp-seek-bar">
                  <div class="jp-play-bar"></div>
                </div>
              </div>
              <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
              </div>
              <div class="jp-time-holder">
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>
                <ul class="jp-toggles">
                  <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                  <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                </ul>
              </div>
            </div>
            <div class="jp-title">
              <ul>
                <li>Choose a song to play</li>
              </ul>
            </div>
            <div class="jp-no-solution">
              <span>Update Required</span>
              To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
          </div>
        </div>
        
    </body>
</html>
