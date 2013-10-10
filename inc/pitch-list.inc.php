				<select id="pitch" name="frm[pitch]">
				<option value="*">Select...</option>
					<?php
					 $utilityDB->GetPitchList($db, $row['pitch_id']);  
					?>
				</select>
