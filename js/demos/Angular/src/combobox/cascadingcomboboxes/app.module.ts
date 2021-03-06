import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { jqxComboBoxModule } from 'jqwidgets-ng/jqxcombobox';
import { jqxDataTableModule } from 'jqwidgets-ng/jqxdatatable';

@NgModule({
  declarations: [
      AppComponent
  ],
  imports: [
      BrowserModule, FormsModule, jqxComboBoxModule, jqxDataTableModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

export class AppModule { }


