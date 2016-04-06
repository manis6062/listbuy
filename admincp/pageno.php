<!--///////////////// PAGING LAST PART//////////////////////////////////////////////////////// -->

	<?PHP
	if($RecordCount > 0)
	{
        //Print First & Previous Link is necessary
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            print "<a href=javascript:jsHitListAction('1') style='text-decoration:none'>First</a>: ";
            print "<a href=javascript:jsHitListAction('$PrevStart') style='text-decoration:none'>".$PrevStart."</a> ";
        }
        //print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "<b>$c</b> ";
                    }else{
                        print "<b>$c</b> ";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href=javascript:jsHitListAction('$c') style='text-decoration:none'>$c</a> ";
                }else{
                    echo "<a href=javascript:jsHitListAction('$c') style='text-decoration:none'>$c</a> ";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "<b>&nbsp;$c&nbsp;</b> ";
                    break;
                }else{
                    echo "<a href=javascript:jsHitListAction('$c') style='text-decoration:none'>&nbsp;$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      //echo "] ";

      if($CounterEnd < $MaxPage){
          $NextPage = $PageNo + 1;
          echo "<a href=javascript:jsHitListAction('$NextPage') style='text-decoration:none'>".$NextPage."</a>";
      }
	  
      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }
        print " : ";
        echo "<a href=javascript:jsHitListAction('$MaxPage') style='text-decoration:none'> Last </a>";
        }
	}   
?>
<!--///////////////// PAGING LAST PART//////////////////////////////////////////////////////// -->