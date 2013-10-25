<!-- Logic to handle editing graphic panels -->
<a title="Edit Part" class="edit" href="<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=E&cat=<?php echo $row['category_id'];?>"><div class="actionEdit"></div></a>
<a href="" title="Delete Part" class="delete" pn="<?php echo $row['part_number'];?>" ct="<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>

<?php 
if($row['category_id']!='KT') {
	echo '<a href="" title="Print Pick Ticket" class="print" ocat="'. $row['category_id'] .'" oid="'. $row['part_number']. '"><div class="printPartTicket"></div></a>';
} else 
	echo '<a href="" title="Print Pick Ticket" class="print" ocat="'. $row['category_id'] .'" oid="'. $row['part_id'] .'"><div class="printPartTicket"></div></a>';
?>