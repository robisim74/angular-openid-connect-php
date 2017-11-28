import { Component, OnInit } from '@angular/core';

import { OAuthService } from 'angular-oauth2-oidc';

@Component({
    selector: 'app-unauthorized',
    templateUrl: './unauthorized.component.html',
    styleUrls: ['./unauthorized.component.scss']
})
export class UnauthorizedComponent implements OnInit {

    constructor(private oAuthService: OAuthService) { }

    ngOnInit() {
        //
    }

    login(): void {
        this.oAuthService.initImplicitFlow();
    }

}
