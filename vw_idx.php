<?php /* earnings $Id: vw_idx_new.php,v .1 2004/08/01 00:41:38 stradius Exp $ */
GLOBAL $AppUI, $earnings, $company_id, $pstatus;
$df = $AppUI->getPref('SHDATEFORMAT');
?>
<form action='./index.php' method='get'>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tbl">
<tr>
	<td align="right" width="65" nowrap="nowrap">&nbsp;<?php echo $AppUI->_('sort by');?>:&nbsp;</td>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=earning_date" class="hdr"><?php echo $AppUI->_('Date');?></a>
	</th>
	<?php if ( $AppUI->user_type != 6 ) { ?>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=earning_num" class="hdr"><?php echo $AppUI->_('Invoice Number');?></a>
	</th>
	<? } else { ?>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=earning_num" class="hdr"><?php echo $AppUI->_('Timecard Number');?></a>
	</th>
	<? } ?>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=company_name" class="hdr"><?php echo $AppUI->_('To Company');?></a>
	</th>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=earning_submit_contact" class="hdr"><?php echo $AppUI->_('Contact');?></a>
	</th>
	<?php if ( $AppUI->user_type != 6 ) { ?>
	<th nowrap="nowrap">
		<a href="?m=earnings&orderby=earning_terms" class="hdr"><?php echo $AppUI->_('Terms');?></a>
	</th>
	<th nowrap="nowrap">
		<?php echo $AppUI->_('Total');?>
	</th>
	<?php } else { ?>
	<th nowrap="nowrap"></th>
	<th nowrap="nowrap"></th>
	<?php } ?>
</tr>

<?php
$CR = "\n";
$CT = "\n\t";
$none = true;
$grand_total = 0;
if ( strcmp($earnings,"") == 0) {
	echo "<tr><td colspan='7'>No forms available</td></tr>";
} else {
	foreach ($earnings as $row) {
		$none = false;
		$inv_date = intval( @$row["earning_date"] ) ? new CDate( $row["earning_date"] ) : null;
		$s = '<tr>';
		$s .= '<td width="32" align="center" style="border: outset #eeeeee 2px;background-color:#FFFFFF">';
		$s .= $CR . '</td>';
		$s .= $CR . '<td width="50" align="center">';
		$s .= $CT . $inv_date->format($df);
		$s .= $CR . '</td>';
		$s .= $CR . '<td width="50" align="center">';
		$s .= $CT . '<a href="?m=earnings&a=view&earning_id=' . $row["earning_id"] . '" title="earning# ' . $row["earning_num"] . '">' . $row["earning_num"] . '</a>';
		$s .= $CR . '</td>';
		$s .= $CR . '<td width="100%" nowrap="nowrap">' . $row["company_name"] . '</td>';
		$s .= $CR . '<td width="100%" nowrap="nowrap">';
		$s .= $CT . $row["earning_submit_contact"];
		$s .= $CR . '</td>';
		if ( $AppUI->user_type != 6 ) {
			$s .= $CR . '<td align="center" nowrap="nowrap">';
			$s .= $CT . $row["earning_terms"];
			$s .= $CR . '</td>';
			$s .= $CR . '<td align="center" nowrap="nowrap">';
			$s .= $CT . '$' . number_format($row["earning_total"], 2, '.', ',');
			$s .= $CR . '</td>';
		} else {
			$s .= $CR . '<td></td>';
			$s .= $CR . '<td></td>';
		}
		$s .= $CR . '</tr>';
		echo $s;
		$grand_total += $row["earning_total"];
	}
}
echo "<tr><td colspan='7'></td></tr>";
if ( $AppUI->user_type != 6 ) {
	echo "<tr><td colspan='6' align='right'>GRAND&nbsp;TOTAL:&nbsp;&nbsp;</td>";
	echo "<td>$" . number_format($grand_total,2,'.',',') . "</td></tr>";
}
?>

</table>
</form>
