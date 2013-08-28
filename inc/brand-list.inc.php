				<select id="brand" name="frm[brand]">
					<option value="*">Select...</option>
					<?php
					 $utilityDB->LookupList($row['product_brand_id'], Constants::TABLE_BRAND_LIST);   
					?>
				</select>
