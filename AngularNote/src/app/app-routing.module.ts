import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {NotesComponent} from './notes/notes.component';
import {CategoriesComponent} from './categories/categories.component';
import {NoteUpdateComponent} from './note-update/note-update.component';
import {AddcategorieComponent} from './addcategorie/addcategorie.component';
import {NoteFormComponent} from './note-form/note-form.component';



import {HttpClientModule} from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';

const routes: Routes = [
  { path : 'notes', component: NotesComponent},
  { path : 'categories', component: CategoriesComponent},
  { path : 'noteUpdate/:id', component: NoteUpdateComponent},
  { path : 'addcategorie', component: AddcategorieComponent},
  { path : 'addnote', component: NoteFormComponent},


];


@NgModule({

 exports: [ RouterModule ],
 imports: [ RouterModule.forRoot(routes),
BrowserModule,
HttpClientModule, ]



})
export class AppRoutingModule { }
