	
	 <form id="formCustomer" method="post" >
			<table id="tableCustomerMaint" align="center">
				<tr>
					<td> 
						<Label>DBA Name</>
					</td>
					<td colspan="3">
						<input id="dbaName" name="frm[dbaName]" type="text" value="<?php echo $row['dba']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Customer Number</label>
					</td>
					<td>
						<input id="customerNumber" name="frm[customerNumber]" type="text" value="<?php echo $row['customer_number'];?>" />
					</td>
					<td align="right">
						<label>Discount Level</label>
					</td>
					<td>
						<input id="discountPct" name="frm[discountPct]" type="text" value="<?php echo $row['discount'];?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Tax rate</label>
					</td>
					<td>
						<input id="taxable" name="frm[taxable]" type="text" value="<?php echo $row['taxable'];?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<label>Address</label>
					</td>
					<td colspan="3">
						<input id="address" name="frm[address]" type="text" value="<?php echo $row['address'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>City/State/Zip</label>
					</td>
					<td>
						<input id="city" name="frm[city]" type="text" value="<?php echo $row['city'];?>"/>
					</td>
					<td>
						<select id="state" name="frm[state]">
							<option value="*">Select...</option>
							<?php
							 echo $utilityDB->LookupList($row['state'], Constants::TABLE_STATE_LIST);  
							?>
						</select>
					</td>
					<td>
						<input id="zip" name="frm[zip]" type="text" value="<?php echo $row['zip'];?>"/>
					</td>
				</tr>

				<tr style="background-color: #efefef">
					<td >
						<label>Billing Address</label>
					</td>
					<td colspan="3">
						<input id="billingAddress" name="frm[billingAddress]" type="text" value="<?php echo $row['billing_address'];?>"/>
					</td>
				</tr>
				<tr style="background-color: #efefef">
					<td>
						<label>City/State/Zip</label>
					</td>
					<td>
						<input id="billingCity" name="frm[billingCity]" type="text" value="<?php echo $row['billing_city'];?>"/>
					</td>
					<td>
						<select id="billingState" name="frm[billingState]">
							<option value="*">Select...</option>
							<?php
							 echo $utilityDB->LookupList($row['billing_state'], Constants::TABLE_STATE_LIST);  
							?>
						</select>
					</td>
					<td>
						<input id="billingZip" name="frm[billingZip]" type="text" value="<?php echo $row['billing_zip'];?>"/>
					</td>
				</tr>				
				<tr>
					<td>
						<label>Phone#1/Phone#2/Fax</label>
					</td>
					<td>
						<input id="phone1" name="frm[phone1]" type="text" value="<?php echo $row['phone1'];?>"/>
					</td>
					<td>
						<input id="phone2" name="frm[phone2]" type="text" value="<?php echo $row['phone2'];?>"/>
					</td>
					<td>
						<input id="fax" name="frm[fax]" type="text" value="<?php echo $row['fax'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>email</label>
					</td>
					<td colspan="3">
						<input id="email" name="frm[email]" type="text" value="<?php echo $row['email'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc1" name="frm[cc1]" type="text" value="<?php echo $row['cc_num1'];?>"/>
					</td>
					<td>
						<input id="exp1" name="frm[exp1]" type="text" value="<?php echo $row['cc_exp1'];?>"/>
					</td>
					<td>
						<input id="cvv1" name="frm[cvv1]" type="text"value="<?php echo $row['cc_cvv1'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc2" name="frm[cc2]" type="text" value="<?php echo $row['cc_num2'];?>"/>
					</td>
					<td>
						<input id="exp2" name="frm[exp2]" type="text" value="<?php echo $row['cc_exp2'];?>"/>
					</td>
					<td>
						<input id="cvv2" name="frm[cvv2]" type="text" value="<?php echo $row['cc_cvv2'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Notes</label>
					</td>
					<td colspan="3">
						<textarea id="notes" name="frm[notes]"><?php echo $row['notes'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label>Status</label>
					</td>
					<td>
						<span class="statusMessage"><?php echo $utility->GetRecStatus( $row['rec_status'] );?></span>
					</td>
				</tr>
											
			</table>
		
		<hr/>
		<div id="formCommands">
			<input id="submitCustomer" name="submitCustomer" value="Save Customer" type="submit"/>
			<?php
			require "formCommand.inc.php";
			$recMode='';
			?>
		</div>
	<!-- end of form --> 
		<input type="hidden" id="customerID" name="frm[customerID]" value="<?php echo $row['customer_id'];?>" />
		<input type="hidden" id="rec_mode" name="frm[rec_mode]" value="<?php echo $recMode;?>" />
		<input id="recstStatus" name="frm[recStatus]" value="<?php echo $row['rec_status'] ?>" type="hidden"/>
		<input type="hidden" value="7147234478" />
	</form>
