<!-- Logic to handle editing graphic panels -->
<a title="Edit Part" class="edit" href="<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=E&cat=<?php echo $row['category_id'];?>"><div class="actionEdit"></div></a>
<a href="" title="Delete Part" class="delete" pn="<?php echo $row['part_number'];?>" ct="<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>
