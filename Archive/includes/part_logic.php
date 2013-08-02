					<?php if( strtolower($recMode) == 'e' ) { ?>
						<input id="masterPartNumber" name="frm[partNumber]" type="hidden" value="<?php echo $row['part_number']?>"/>
						<span id="masterPartNumberSpan"><?php echo $row['part_number']?></span>
					<?php } else  {?>
						<input id="masterPartNumber" name="frm[partNumber]" type="text" value="<?php echo $row['part_number']?>"/>
					<?php } ?>
