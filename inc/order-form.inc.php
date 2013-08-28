<div id="dialog-orderItem" >
	<fieldset class="entryForm">
		<legend>Part Information</legend>
		<div class="group">
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="partNumber">Part Number</label><br/>
					<input id="partNumber"  name="frm[partNumber]" type="text" value="<?php echo $row['part_number']?>" size="25" />
				</div>
			</div>
			<div class="kitSpacers">
				<label for="discount">Cust %</label><br/>
				<input class="calculate" id="discount" name="frm[discount]" type="text"  value="" size="5"/>
			</div>
		</div>
		<div class="group">
			<div class="kitSpacers">
				<label for="description">Description</label><br/>
				<textarea  id="description" cols="40"></textarea>
			</div>
			<div class="kitSpacers">
				<label for="application">Application</label><br/>
				<textarea  id="application" cols="40"></textarea>
			</div>
		</div>		

		<div class="group" id="entryKit">		
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="frontSprocket">Front Sprocket</label><br/>
					<input id="frontSprocket"  name="frm[frontSprocket]" type="text" value="<?php echo $row['part_number']?>" size="25"/>
				</div>
			</div>
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="rearSprocket">Rear Sprocket</label><br/>
					<input id="rearSprocket"  name="frm[rearSprocket]" type="text" value="<?php echo $row['part_number']?>" size="25"/>
				</div>
			</div>			
			<div class="kitSpacers">
				<label for="chainLength">Length</label><br/>
				<input class="calculate" id="chainLength" name="frm[chainLength]" type="text" value="" size="5"/>
			</div>
		</div>

		<div class="group" id="entrySprocket">	
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="category">Category</label><br/>
					<input id="category"  name="frm[category]" type="text" value="" size="10"/>
				</div>
			</div>
	
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="frontSprocket">Sprocket</label><br/>
					<input id="frontSprocket"  name="frm[frontSprocket]" type="text" value="<?php echo $row['part_number']?>" size="25"/>
				</div>
			</div>
			<div class="kitSpacers">
				<div class="ui-widget">
					<label for="rearSprocket">Rear Sprocket</label><br/>
					<input id="rearSprocket"  name="frm[rearSprocket]" type="text" value="<?php echo $row['part_number']?>" size="25"/>
				</div>
			</div>			
			<div class="kitSpacers">
				<label for="chainLength">Length</label><br/>
				<input class="calculate" id="chainLength" name="frm[chainLength]" type="text" value="" size="5"/>
			</div>
		</div>

		
		<div class="group" id="entryChain">		
			<div class="kitSpacers">
				<div class="ui-widget">
				<?php
				include 'inc/brand-list.inc.php';
				?>
				</div>
			</div>
			<div class="kitSpacers">
				<div class="ui-widget">
				<?php 
				include 'inc/clip-list.inc.php';
				?>
				</div>
			</div>			
		</div>
				
	</fieldset>	


<!-- Pricing -->	
	<fieldset class="entryPricing">
		<legend>Pricing</legend>
			<div class="group">
			<div class="kitSpacers">
				<label for="msrp" >MSRP</label><br/>
				<input class="calculate" id="msrp" name="frm[msrp]" type="text"  value="0.00" size="10" style="text-align:right"/>
			</div>

			<div class="kitSpacers">
				<label for="qty">Qty</label><br/>
				<input class="calculate" id="qty" name="frm[qty]" type="text" value="1" size="5"/>
			</div>
			<div class="kitSpacers">
				<label for="save-price" >Discount</label><br/>
				<input class="nocalculate" id="discount-price" name="frm[discount-price]" type="text"  value="0.00" size="10" style="text-align:right"/>
			</div>		
			<div class="kitSpacers">
				<label for="unit-price" >Unit Price</label><br/>
				<input class="nocalculate" id="unit-price" name="frm[unit-price]" type="text"  value="0.00" size="10" style="text-align:right"/>
			</div>
			<div class="kitSpacers">
				<label for="total" >Total</label><br/>
				<input id="total" name="frm[total]" type="text"  value="0.00" size="10" style="text-align:right"/>
			</div>
	</fieldset>
	
	<div class="group">
		<div class="kitSpacers">
			<br/>
			<input type="button" id="line-createItem" name="frm[createItem]" value="Create Order Item"/>
		</div>
	</div>
	
	
<!-- Chain Chart -->
	<div class="group">
		<div id="chainChart">
			<div id="chartList">Please select a pitch to select a chain</div>
		</div>
	</div>

<input type="hidden" id="h_pitch"/>
<input type="hidden" id="h_length"/>
<input type="hidden" id="h_chain"/>
<input type="hidden" id="h_fs"/>
<input type="hidden" id="h_rs"/>
<input type="hidden" id="h_ch"/>
</div>
