<?php //backups.php

if(empty($_SESSION['user'])) 
{ 
header("Location: index.php"); 
die; 
} 

?>
<div class="container">
    <div class="backups">
        <h2>Tills</h2>

    <?php

        $dirOptions = array('Daily', 'Weekly', 'Monthly' );
        foreach ( $dirOptions as $type ) {
            $dir = '/server/tills/'.$type.'/';
            $files = array_diff(scandir($dir, 1), array('..', '.'));
            $X = 2;
            echo '<h3>'.$type.'</h3>';
            for( $i = 0; $i<$X; $i++ ) {
                print_r ("<div class=\"files\"><a href=\"download.php?filename=$files[$i]&description=tills".$type."\">");
                echo 'Volante ';
                echo strrpos($files[$i], 'log' ) ? 'log' : 'db' ;

                echo (date (" | j<\s\u\p>S<\/\s\u\p> M 'y", filectime("$dir"."$files[$i]")));
                print_r ("</a></div>");
            }    
        }

    ?> 
    </div>        
    <div class="backups">
        <h2>PMS</h2>
    <?php

        $dir    = '/server/PMS/Backup/';
        $files = preg_grep('/^([^.])/', scandir($dir, 1)); //(, 1 )denotes ascending/decending order
        $X = count($files);
        for( $i = 0; $i<$X; $i++ ){
            print_r ("<div class=\"files\"><a href=\"download.php?filename=$files[$i]&description=PMS\">");      
            $fls = str_replace('HotSoft_','',$files[$i]);
            $fls = str_replace('_Abbeyleix_Mano.zip','',$fls);
            $fls = explode('_', $fls);
            echo 'HotSoft ';
            echo $fls[1] > 1200 ? 'PM' : 'AM' ;
            echo (date (" | D, j<\s\u\p>S<\/\s\u\p> F \'y", strtotime($fls[0]))); 
            print_r ("</a></div>");
        }
        print_r ("FileCount: ".$X);

    ?> 
    </div>
</div>