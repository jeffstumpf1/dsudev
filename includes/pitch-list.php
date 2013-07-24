				<select id="pitch" name="frm[pitch]">
				<option value="*">Select...</option>
					<?php
					 echo $utility->GetPitchList($db, $row['pitch_id']);  
					?>
				</select>
