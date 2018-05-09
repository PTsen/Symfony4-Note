import { Component, OnInit, Input, Output } from '@angular/core';
import {Note} from '../note';
import {Categorie} from '../categorie';
import { NoteRestService } from '../note-rest.service';
import { CategoriesRestService } from '../categories-rest.service';

import { Router, ActivatedRoute, ParamMap } from '@angular/router';
import { switchMap } from 'rxjs/operators';
import { Observable } from 'rxjs/Observable';
import { format } from 'url';



@Component({
  selector: 'app-note-update',
  templateUrl: './note-update.component.html',
  styleUrls: ['./note-update.component.css']
})
export class NoteUpdateComponent implements OnInit {
 note$ : Observable<Note[]>;
 categories : Categorie[];

  constructor(  private route: ActivatedRoute,
    private router: Router,
    private noteService: NoteRestService,
    private categorieService: CategoriesRestService
  ) { 

    }

  ngOnInit() {


    this.categorieService.getCategories()
    .subscribe(categories => this.categories = categories);;

    this.note$ = this.route.paramMap.pipe(
      switchMap((params: ParamMap) =>
        this.noteService.getNote(params.get('id')))
    );
 
  }

  save(note : Note ): void {
    var d = new Date(note.date['year'],note.date['month'],note.date['day']);
    note.date=d;
    this.noteService.updateNote(note)
      .subscribe();
      this.router.navigate(['/']);
  }

}
