<?php

//- Variables - for your RPT and PDF
echo "Export rpt Crystal Report ON pdf";
$my_report = "C:\\xampp\\htdocs\\ppi-manage\\report\\product_list2.rpt"; 
$my_pdf = "C:\\xampp\\htdocs\\ppi-manage\\report\\export\\product_list.pdf"; 

//- Variables - Server Information 
$my_server = "SERVER2"; 
$my_user = "ppi_report"; 
$my_password = "Denki@05121996"; 
$my_database = "ppi";
$COM_Object = "CrystalDesignRunTime.Application";

$crapp= New COM($COM_Object) or die("Unable to Create Object");
$creport = $crapp->OpenReport($my_report, 1);

// $ObjectFactory= new COM("CrystalReports14.ObjectFactory.1") or die ("Error on load"); // call COM port 
// $crapp = $ObjectFactory->CreateObject("CrystalRunTime.Application.14"); // create an instance for Crystal 
// $creport = $crapp->OpenReport($my_report, 1); // call rpt report 
 
//- Set database logon info - must have 
$creport->Database->Tables(1)->SetLogOnInfo($my_server, $my_database, $my_user, $my_password);
//- field prompt or else report will hang - to get through 
$creport->EnableParameterPrompting = 0;
//------ DiscardSavedData make a Refresh in your data -------
$creport->DiscardSavedData;
$creport->ReadRecords();

   
//export to PDF process
$creport->ExportOptions->DiskFileName=$my_pdf; //export to pdf
$creport->ExportOptions->PDFExportAllPages=true;
$creport->ExportOptions->DestinationType=1; // export to file
$creport->ExportOptions->FormatType=31; // PDF type
$creport->Export(false);

//------ Release the variables ------
$creport = null;
$crapp = null;
$ObjectFactory = null;

//------ Embed the report in the webpage ------
// print "<embed src=\"C:\\xampp\\htdocs\\ppi-manage\\report\\export\\product_list.pdf\" width=\"100%\" height=\"100%\">"


$file = "C:\\xampp\\htdocs\\ppi-manage\\report\\export\\product_list.pdf"; 

header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

readfile ($file);
exit(); 

?>