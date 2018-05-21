import { Injectable } from '@angular/core';
import {Note} from './note';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  
};

/**
* Note service that connect to the Note API REST from Symfony 
*/

@Injectable()
export class NoteRestService {

  constructor(private http:HttpClient) { }
  
  private noteUrl = 'http://localhost/myProj/public/index.php/apiAngular/note'

  getNotes(): Observable<Note[]> {
   return this.http.get<Note[]>(this.noteUrl+"/list");
  }

  getNote(id : string): Observable<Note[]> {
   
    const url = `${this.noteUrl}/get/${id}`;
    return this.http.get<Note[]>(url);
   }

  deleteNote(note : Note | number):Observable<Note> {

    const id = typeof note === 'number' ? note : note.id;
    const url = `${this.noteUrl}/delete/${id}`;

    return this.http.delete<Note>(url, httpOptions)
   }


   updateNote (note: Note): Observable<any> {
    console.log(note);
    return this.http.put(this.noteUrl+"/put", note, httpOptions)
  }

  addNote(note : Note ) {
    return this.http.post(this.noteUrl+"/create", note, httpOptions);
   }


}
