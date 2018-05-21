import { Component, OnInit } from '@angular/core';
import { CategoriesRestService } from '../categories-rest.service';
import { Router} from '@angular/router';

/**
* Component that add a category
*/

@Component({
  selector: 'app-addcategorie',
  templateUrl: './addcategorie.component.html',
  styleUrls: ['./addcategorie.component.css']
})
export class AddcategorieComponent implements OnInit {
categorie:string; 
  constructor(private categoriesRestService : CategoriesRestService,
  private router: Router) { }

  ngOnInit() {
  }

saveCat(){
  this.categoriesRestService.addCategorie(this.categorie).subscribe(); 
  this.router.navigate(['/']);
}

}
