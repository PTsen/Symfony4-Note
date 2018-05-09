import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import {Note} from '../note';
import {Categorie} from '../categorie';
import { NoteRestService } from '../note-rest.service';
import { CategoriesRestService } from '../categories-rest.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-note-form',
  templateUrl: './note-form.component.html',
  styleUrls: ['./note-form.component.css']
})
export class NoteFormComponent implements OnInit {
  
  categories : Categorie[];
  private note$ : Note
  private title: string;
  private note: string;
  private date : Date;
  private cate : string;
  constructor(   private noteService: NoteRestService,
    private router: Router,
    private categorieService: CategoriesRestService ) {this.note$ = new Note(); 
    this.note="";}

  ngOnInit() {
    this.categorieService.getCategories()
    .subscribe(categories => this.categories = categories);;

  }

  add( ){
    
    var d = new Date(this.date['year'],this.date['month'],this.date['day']);
    this.note$.date=d;
    this.note$.title=this.title;
    this.note$.categorie=this.cate;
    this.note$.note= '<?xml version="1.0" encoding="UTF-8"?><note>'+this.note +"</note>";
    this.noteService.addNote(this.note$).subscribe();
    this.router.navigate(['/']);

  }




}
