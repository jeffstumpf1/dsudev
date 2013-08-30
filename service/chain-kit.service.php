<?php
//   chain-kit.service.php


?>

			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" style="margin-left:0">Part Number</label><br/>
					<label><?php echo $row['part_number']?></label>
				</div>
				
			</div>
				<div class="kitSpacers">
					<label class="titleTop" for="pitch">Pitch</label><br/>
<?php 
include 'inc/pitch-list.inc.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="fsPartNumber">Front Sprocket</label><br/>
					<input id="fsPartNumber"  name="frm[fsPartNumber]" type="text" value="<?php echo $row['frontSprocket_part_number']?>" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="rsPartNumber">Rear Sprocket</label><br/>
					<input id="rsPartNumber"  name="frm[rsPartNumber]" type="text" value="<?php echo $row['rearSprocket_part_number']?>" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="chainLength">Chain Length</label><br/>
					<input id="chainLength"  name="frm[chainLength]" type="text" value="<?php echo $row['chain_length']?>" />
				</div>

			</div>
			<div class="group">
			</div>
				
			
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" for="msrp">MSRP</label><br/>
					<input id="msrp"  name="frm[msrp]" type="text" value="<?php echo $row['msrp']?>" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="dealerCost">Dealer Cost</label><br/>
					<input id="dealerCost"  name="frm[dealerCost]" type="text" value="<?php echo $row['dealer_cost']?>" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="importCost">Import Cost</label><br/>
					<input id="importCost"  name="frm[importCost]" type="text" value="<?php echo $row['import_cost']?>" />
				</div>
				
			</div>
			
			<div class='group'>
				<div class="kitSpacersDesc">	
					<label class="titleTop" style="margin-left:0" for="fsPartNumber">Description</label>
					<textarea id="notes" name="frm[notes]" style="margin-left:0"><?php echo $row['part_description']?></textarea>
				</div>	
			</div>			
