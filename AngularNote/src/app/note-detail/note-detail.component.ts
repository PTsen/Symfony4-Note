import { Component, OnInit, Input, Output } from '@angular/core';
import {Note} from '../note';
import { NoteRestService } from '../note-rest.service';

import { EventEmitter } from '@angular/core';
import { DatePipe } from '@angular/common';


/**
 * Component that display more detail about a note
 * The note can be delete
 */

@Component({
  selector: 'app-note-detail',
  templateUrl: './note-detail.component.html',
  styleUrls: ['./note-detail.component.css']
})

export class NoteDetailComponent implements OnInit {
  @Input() note: Note;
  @Input() notes: Note[];
  @Output() close: EventEmitter<any> = new EventEmitter();

  constructor(private noteRestService : NoteRestService) {   }

  ngOnInit() {
  }

  onDelete(note : Note) : void{
    this.notes=this.notes.filter(n=> n!==note);
    this.noteRestService.deleteNote(note).subscribe();
    this.close.emit(this.notes);
    this.note=null;
  } 

  

}
