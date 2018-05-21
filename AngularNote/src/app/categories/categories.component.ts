import { Component, OnInit } from '@angular/core';
import {Categorie} from '../categorie'
import { CategoriesRestService } from '../categories-rest.service';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';


/**
 * Component that display and update or delete a category
 */

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {
  categories : Categorie[];
  constructor(private categoriesRestService : CategoriesRestService,
  private router: Router
  ) { }

  ngOnInit() {
    this.getCategories();
  }

  getCategories(): void {
    this.categoriesRestService.getCategories()
     .subscribe(categories => this.categories = categories);
 }


 onUpdate(cate : Categorie): void{
 
    this.categoriesRestService.updateCategorie(cate)
      .subscribe();
     this.router.navigate(['/']);
}

  onDelete(cat : Categorie) : void{
    this.categories=this.categories.filter(n=> n!==cat);
    this.categoriesRestService.deleteCategorie(cat).subscribe();
  } 
}
