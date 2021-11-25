import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FreeDialogComponent } from './free-dialog.component';

describe('FreeDialogComponent', () => {
  let component: FreeDialogComponent;
  let fixture: ComponentFixture<FreeDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FreeDialogComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FreeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
