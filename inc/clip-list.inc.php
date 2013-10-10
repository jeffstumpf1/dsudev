				<select id="clip" name="frm[clip]">
				<option value="*">Select...</option>
					<?php
					 $utilityDB->GetClipList($db, $row['clip_id']); 
					?>
				</select>
