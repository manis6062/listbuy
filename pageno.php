<!--///////////////// PAGING LAST PART//////////////////////////////////////////////////////// -->

	<?PHP
	if($prpgrec > $PageSize){
	if($RecordCount > 0)
	{
        //Print First & Previous Link is necessary
		echo "<table align='right'><tr>";
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            print "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('1') style='text-decoration:none'>First</a> </td>";
            print "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$PrevStart') style='text-decoration:none'>".$PrevStart."</a> </td>";
        }
        //print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "<td width='4' align='right' class='paging'><b>$c</b></td>";
                    }else{
                        print "<td width='4' align='right' class='paging'><b>$c</b></td>";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$c') style='text-decoration:none'>$c</a></td>";
                }else{
                    echo "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$c') style='text-decoration:none'>$c</a></td>";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "<td width='4' align='right' class='paging'><b>&nbsp;$c&nbsp;</b></td>";
                    break;
                }else{
                    echo "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$c') style='text-decoration:none'>&nbsp;$c</a></td>";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      //echo "] ";

      if($CounterEnd < $MaxPage){
          $NextPage = $PageNo + 1;
          echo "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$NextPage') style='text-decoration:none'>".$NextPage."</a></td>";
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
        //print " : ";
        echo "<td width='4' align='right' class='paging'><a href=javascript:jsHitListAction('$MaxPage') style='text-decoration:none'> Last </a></td>";
        }
		echo "</tr></table>";
	}   
	}
?>
<!--///////////////// PAGING LAST PART//////////////////////////////////////////////////////// -->