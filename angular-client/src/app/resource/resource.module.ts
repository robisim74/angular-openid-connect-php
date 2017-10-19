import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ResourceRoutingModule } from './resource-routing.module';
import { ResourceComponent } from './resource.component';

@NgModule({
    imports: [
        CommonModule,
        ResourceRoutingModule
    ],
    declarations: [ResourceComponent]
})
export class ResourceModule { }
