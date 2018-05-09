import { BrowserModule } from '@angular/platform-browser';
import { FormsModule,ReactiveFormsModule } from '@angular/forms';
import { AppComponent } from './app.component';
import { AppRoutingModule } from './/app-routing.module';



/**
 * Own method
 */
import { NotesComponent } from './notes/notes.component';
import { CategoriesComponent } from './categories/categories.component';
import { NoteRestService} from './note-rest.service'
import { CategoriesRestService} from './categories-rest.service';
import { NoteDetailComponent } from './note-detail/note-detail.component';
import { NoteFormComponent } from './note-form/note-form.component';
import { AddcategorieComponent } from './addcategorie/addcategorie.component';




/**
 * Design
 */
import { NoteUpdateComponent } from './note-update/note-update.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import { NgModule } from '@angular/core';



@NgModule({
  declarations: [
    AppComponent,
    NotesComponent,
    CategoriesComponent,
    NoteDetailComponent,
    NoteUpdateComponent,
    AddcategorieComponent,
    NoteFormComponent  ],

  imports: [
    BrowserModule,
    AppRoutingModule, 
    FormsModule,
    ReactiveFormsModule,
    NgbModule.forRoot()
  ],

  providers: [NoteRestService,CategoriesRestService],
  
  bootstrap: [AppComponent]
})
export class AppModule { }
