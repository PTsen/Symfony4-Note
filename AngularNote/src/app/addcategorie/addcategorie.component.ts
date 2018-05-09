import { Component, OnInit } from '@angular/core';
import { CategoriesRestService } from '../categories-rest.service';


@Component({
  selector: 'app-addcategorie',
  templateUrl: './addcategorie.component.html',
  styleUrls: ['./addcategorie.component.css']
})
export class AddcategorieComponent implements OnInit {
categorie:string; 
  constructor(private categoriesRestService : CategoriesRestService) { }

  ngOnInit() {
  }

saveCat(){
  this.categoriesRestService.addCategorie(this.categorie).subscribe(); 
}

}
