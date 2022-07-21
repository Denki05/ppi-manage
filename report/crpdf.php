<?php
       $word = @new COM("Word.Application") or die ("Could not initialise Object.");
       // set it to 1 to see the MS Word window (the actual opening of the document)
       $word->Visible = 0;
       // recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
       $word->DisplayAlerts = 0;
       // open the word 2007-2013 document 
       $word->Documents->Open('C:\xampp\htdocs\ppi-manage\report\tes_print.docx');
       // save it as word 2003
       $word->ActiveDocument->SaveAs('C:\xampp\htdocs\ppi-manage\report\export\tes_print_export.doc');
       // convert word 2007-2013 to PDF
       $word->ActiveDocument->ExportAsFixedFormat('C:\xampp\htdocs\ppi-manage\report\export\tes_print_export_pdf.pdf', 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
       // quit the Word process
       $word->Quit(true);
       // clean up
       unset($word);
?>