				<select id="brand" name="frm[brand]">
					<option value="*">Select...</option>
					<?php
					 $utilityDB->GetBrandList($db, $row['product_brand_id']);   
					?>
				</select>
