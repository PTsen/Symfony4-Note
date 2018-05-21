import { Injectable } from '@angular/core';
import {Categorie} from './categorie';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { HttpClient, HttpHeaders } from '@angular/common/http';


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  
};

/**
* Category service that connect to the Category API REST from Symfony 
*/

@Injectable()
export class CategoriesRestService {

  constructor(private http:HttpClient) { }
  private categorieUrl = 'http://localhost/myProj/public/index.php/apiAngular/categorie'

  getCategories(): Observable<Categorie[]> {
   return this.http.get<Categorie[]>(this.categorieUrl+"/list");
  }

  deleteCategorie(cat : Categorie | number):Observable<Categorie> {

    const id = typeof cat === 'number' ? cat : cat.id;
    const url = `${this.categorieUrl}/delete/${id}`;
    return this.http.delete<Categorie>(url, httpOptions);
   }

   updateCategorie(cat : Categorie ){
    return this.http.put(this.categorieUrl+"/put", cat, httpOptions);
   }

   addCategorie(cat : string ) {
    return this.http.post(this.categorieUrl+"/create", cat, httpOptions);
   }

}
