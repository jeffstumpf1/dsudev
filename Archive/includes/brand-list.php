				<select id="brand" name="frm[brand]">
					<option value="*">Select...</option>
					<?php
					 echo $utility->GetBrandList($db, $row['brand_id']);  
					?>
				</select>
