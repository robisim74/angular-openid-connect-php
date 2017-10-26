import { Component, OnInit } from '@angular/core';

import { OidcSecurityService } from 'angular-auth-oidc-client';

@Component({
    selector: 'app-signin',
    templateUrl: './signin.component.html',
    styleUrls: ['./signin.component.scss']
})
export class SigninComponent implements OnInit {

    constructor(private oidcSecurityService: OidcSecurityService) { }

    ngOnInit() {
        //
    }

    login(): void {
        this.oidcSecurityService.authorize();
    }

}
