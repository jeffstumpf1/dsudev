				<select id="clip" name="frm[clip]">
				<option value="*">Select...</option>
					<?php
					 $utilityDB->LookupList($row['clip_id'], Constants::TABLE_CLIP_LIST); 
					?>
				</select>
