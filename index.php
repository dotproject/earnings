<?php  /* earnings $Id: index.php,v .1 2004/08/01 00:41:38 Stradius Exp $ */
$AppUI->savePlace();

// retrieve any state parameters
// Such as which tab was last selected and which columns have been selected for sorting the output.
if (isset( $_GET['tab'] )) {
	$AppUI->setState( 'EarnIdxTab', $_GET['tab'] );
}
$tab = $AppUI->getState( 'EarnIdxTab' ) !== NULL ? $AppUI->getState( 'EarnIdxTab' ) : 0;
$active = intval( !$AppUI->getState( 'EarnIdxTab' ) );

if (isset( $_POST['company_id'] )) {
	$AppUI->setState( 'EarnIdxCompany', $_POST['company_id'] );
}
$company_id = $AppUI->getState( 'EarnIdxCompany' ) !== NULL ? $AppUI->getState( 'EarnIdxCompany' ) : $AppUI->user_company;

if (isset( $_GET['orderby'] )) {
	$AppUI->setState( 'EarnIdxOrderBy', $_GET['orderby'] );
}
$orderby = $AppUI->getState( 'EarnIdxOrderBy' ) ? $AppUI->getState( 'EarnIdxOrderBy' ) : 'earning_date';
if ( $orderby == "earning_date" ) {
	$orderby = "earning_date DESC";
}

// retrieve list of earnings and their line_items
// the tab selected tells which query to use
if ( $tab < 0 ) { 
	$tab = 0;
}

switch ($tab) {
case 0:
	// Preparing/New earnings
	$sql = "SELECT earnings.*, companies.company_name FROM earnings, companies WHERE earning_submitted = '0000-00-00 00:00:00' AND earning_submit_company_id = company_id AND earning_user_id=" . $AppUI->user_id . " ORDER BY " . $orderby . ";";
	break;
case 1:
	// Submitted earnings
	$sql = "SELECT earnings.*, companies.company_name FROM earnings, companies WHERE earning_submitted != '0000-00-00 00:00:00' AND earning_approved = '0000-00-00 00:00:00' AND earning_submit_company_id = company_id AND earning_user_id=" . $AppUI->user_id . " ORDER BY " . $orderby . ";";
	break;
case 2:
	// Approved earnings
	$sql = "SELECT earnings.*, companies.company_name FROM earnings, companies WHERE earning_approved != '0000-00-00 00:00:00' AND earning_paid = '0000-00-00 00:00:00' AND earning_submit_company_id = company_id AND earning_user_id=" . $AppUI->user_id . " ORDER BY " . $orderby . ";";
	break;
case 3:
	// Paid earnings
	$sql = "SELECT earnings.*, companies.company_name FROM earnings, companies WHERE earning_paid != '0000-00-00 00:00:00' AND earning_submit_company_id = company_id AND earning_user_id=" . $AppUI->user_id . " ORDER BY " . $orderby . ";";
	break;
case 4:
	// Awaiting Approval
	$sql = "SELECT earnings.*, companies.company_name FROM earnings, companies WHERE earning_approved = '0000-00-00 00:00:00' AND earning_submitted != '0000-00-00 00:00:00' AND earning_submit_company_id = company_id" . " ORDER BY " . $orderby . ";";
	break;
}
$earnings = db_loadList( $sql );

// setup the title block
// customize to user-type
//$titleBlock->addCrumb( "?m=tasks&a=todo", "my todo" );
if ( $AppUI->user_type != 6 ) {
	$titleBlock = new CTitleBlock( 'Earnings', 'earnings.gif', $m, "$m.$a" );
	if ($canEdit) {
		$titleBlock->addCell(
			'<input type="submit" class="button" value="'.$AppUI->_('new invoice').'">', '',
			'<form action="?m=earnings&a=addedit" method="post">', '</form>'
		);
	}
} else {
	$titleBlock = new CTitleBlock( 'Timecards', 'earnings.gif', $m, "$m.$a" );
	if ($canEdit) {
		$titleBlock->addCell(
			'<input type="submit" class="button" value="'.$AppUI->_('new timecard').'">', '',
			'<form action="?m=earnings&a=addedit" method="post">', '</form>'
		);
	}
}
$titleBlock->show();

// tabbed information boxes
$tabBox = new CTabBox( "?m=earnings&orderby=$orderby", "{$AppUI->cfg['root_dir']}/modules/earnings/", $tab );
$tabBox->add( 'vw_idx', 'Prepare' );
$tabBox->add( 'vw_idx', 'Submitted' );
$tabBox->add( 'vw_idx', 'Approved' );
if ( $AppUI->user_type != 6 ) {
	$tabBox->add( 'vw_idx', 'Paid' );
}
if ( $AppUI->user_type < 6 ) {
	$tabBox->add( 'vw_idx', 'Waiting For Approval' );
}


$tabBox->show();

?>
