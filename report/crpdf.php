<?php
       // $word = new com("Word.Application") or die ("Could not initialise Object.");
       // // set it to 1 to see the MS Word window (the actual opening of the document)
       // $word->Visible = 0;
       // // recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
       // $word->DisplayAlerts = 0;
       // // open the word 2007-2013 document 
       // $word->Documents->Open('C:\xampp\htdocs\ppi-manage\report\tes_com.docx');
       // // save it as word 2003
       // $word->ActiveDocument->SaveAs('C:\xampp\htdocs\ppi-manage\report\export\tes_com_export.doc');
       // // convert word 2007-2013 to PDF
       // $word->ActiveDocument->ExportAsFixedFormat('C:\xampp\htdocs\ppi-manage\report\export\tes_com_export.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
       // // quit the Word process
       // $word->Quit(true);
       // // clean up
       // unset($word);

       // starting excel
       $excel = new COM("excel.application") or die("Unable to instanciate excel");
       print "Loaded excel, version {$excel->Version}\n";

       //bring it to front
       $excel->Visible = 1;//NOT
       //dont want alerts ... run silent
       $excel->DisplayAlerts = 0;

       //open  document
       $excel->Workbooks->Open('C:\xampp\htdocs\ppi-manage\report\product_list.xlsx');
       //XlFileFormat.xlcsv file format is 6
       //saveas command (file,format ......)
       $excel->Workbooks[1]->SaveAs('C:\xampp\htdocs\ppi-manage\report\export\product_list.xls',6);

       // $excel->Workbooks[1]->SaveAs('C:\xampp\htdocs\ppi-manage\report\export\product_list.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
       //closing excel
       $excel->Quit();

       //free the object
       // $excel->Release();
       // $excel = null;
?>