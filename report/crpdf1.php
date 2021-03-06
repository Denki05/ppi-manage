<?php

//- Variables - for your RPT and PDF
echo "Print Report Test";
$my_report = "C:\\xampp\\htdocs\\ppi-manage\\report\\product_list.rpt"; 
$my_pdf = "C:\\xampp\\htdocs\\ppi-manage\\report\\export\\product_list.pdf"; 

//- Variables - Server Information 
$my_server = "server_pusat"; 
$my_user = "ppi_report"; 
$my_password = "Denki@05121996"; 
$my_database = "ppi"; 

$ObjectFactory= new COM("CrystalReports13.ObjectFactory.1") or die ("Error on load"); // call COM port 
$crapp = $ObjectFactory->CreateObject("CrystalReports13.ObjectFactory.1"); // create an instance for Crystal 
$creport = $crapp->OpenReport($my_report, 1); // call rpt report 
 
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
print "<embed src=\"C:\\xampp\\htdocs\\ppi-manage\\report\\product_list.pdf\" width=\"100%\" height=\"100%\">"

?>