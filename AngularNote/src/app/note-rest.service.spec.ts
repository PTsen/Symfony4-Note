import { TestBed, inject } from '@angular/core/testing';

import { NoteRestService } from './note-rest.service';

describe('NoteRestService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [NoteRestService]
    });
  });

  it('should be created', inject([NoteRestService], (service: NoteRestService) => {
    expect(service).toBeTruthy();
  }));
});
