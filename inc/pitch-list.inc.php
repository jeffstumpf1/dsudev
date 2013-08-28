				<select id="pitch" name="frm[pitch]">
				<option value="*">Select...</option>
					<?php
					 $utilityDB->LookupList($row['pitch_id'], Constants::TABLE_PITCH_LIST);  
					?>
				</select>
