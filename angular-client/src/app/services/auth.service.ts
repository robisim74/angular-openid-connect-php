import { Injectable } from '@angular/core';
import { HttpHeaders } from '@angular/common/http';

import { OidcSecurityService } from 'angular-auth-oidc-client';


@Injectable() export class AuthService {

    /**
     * Stores the URL so we can redirect after signing in.
     */
    public redirectUrl: string;

    constructor(private oidcSecurityService: OidcSecurityService) { }

    public getAuthorizationHeader(): HttpHeaders {
        // Creates header for the auth requests.
        let headers: HttpHeaders = new HttpHeaders().set('Content-Type', 'application/json; charset=utf-8');
        headers = headers.append('Accept', 'application/json; charset=utf-8');

        const token: string = this.oidcSecurityService.getToken();
        if (token !== '') {
            const tokenValue: string = 'Bearer ' + token;
            headers = headers.append('Authorization', tokenValue);
        }
        return headers;
    }

}
