import { Component, OnInit } from '@angular/core';

import { NoteRestService } from '../note-rest.service';
import {Note} from '../note'


@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.css']
})
export class NotesComponent implements OnInit {

  notes : Note[];

  constructor(private noteRestService : NoteRestService) { }

  ngOnInit() {
    this.getNotes();
  }

  getNotes(): void {
     this.noteRestService.getNotes()
      .subscribe(notes => this.notes = notes);
  }

  selectedNote: Note;

onSelect(note: Note): void {

  this.selectedNote = note;
}

closeDelete(notes: Note[]){
  this.notes = notes;
}

}
