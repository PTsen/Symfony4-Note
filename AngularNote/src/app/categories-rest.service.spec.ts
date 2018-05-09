import { TestBed, inject } from '@angular/core/testing';

import { CategoriesRestService } from './categories-rest.service';

describe('CategoriesRestService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CategoriesRestService]
    });
  });

  it('should be created', inject([CategoriesRestService], (service: CategoriesRestService) => {
    expect(service).toBeTruthy();
  }));
});
