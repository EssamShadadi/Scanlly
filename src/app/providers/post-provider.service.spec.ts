import { TestBed } from '@angular/core/testing';

import { PostProviderService } from './post-provider.service';

describe('PostProviderService', () => {
  let service: PostProviderService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PostProviderService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
