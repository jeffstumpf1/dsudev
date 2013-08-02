				<select id="ml" name="frm[ml]">
				<option value="*">Select...</option>
					<?php
					 echo $utility->GetClipList($db, $row['ml_id']);  
					?>
				</select>
