<?php
$my_report = "C:\\xampp\\htdocs\\ppi-manage\\report\\sales_report2.rpt"; 
$my_pdf = "C:\\xampp\\htdocs\\ppi-manage\\report\\export\\sales_report.pdf";

//- Variables - Server Information 
$my_server = "SERVER2"; 
$my_user = "ppi_report"; 
$my_password = "Denki@05121996"; 
$my_database = "ppi";
$COM_Object = "CrystalDesignRunTime.Application";


//-Create new COM object-depends on your Crystal Report version
$crapp= New COM($COM_Object) or die("Unable to Create Object");
$creport = $crapp->OpenReport($my_report,1); // call rpt report

// to refresh data before

//- Set database logon info - must have
$creport->Database->Tables(1)->SetLogOnInfo($my_server, $my_database, $my_user, $my_password);

//- field prompt or else report will hang - to get through
$creport->EnableParameterPrompting = 0;



// this is the error 

// $zz = $creport->ParameterFields(1)->SetCurrentValue("2022-08-05");    

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

$file = "C:\\xampp\\htdocs\\ppi-manage\\report\\export\\sales_report.pdf"; 

header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 

readfile ($file);
exit(); 



?>