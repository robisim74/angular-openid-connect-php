import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

import { OidcSecurityService, AuthWellKnownEndpoints } from 'angular-auth-oidc-client';


@Injectable() export class AuthService {

    /**
     * Stores the URL so we can redirect after signing in.
     */
    public redirectUrl: string;

    constructor(
        private http: HttpClient,
        private oidcSecurityService: OidcSecurityService,
        private authWellKnownEndpoints: AuthWellKnownEndpoints
    ) { }

    public getAuthorizationHeader(): HttpHeaders {
        // Creates header for the auth requests.
        let headers: HttpHeaders = new HttpHeaders().set('Content-Type', 'application/json');
        headers = headers.append('Accept', 'application/json');

        const token: string = this.oidcSecurityService.getToken();
        if (token !== '') {
            const tokenValue: string = 'Bearer ' + token;
            headers = headers.append('Authorization', tokenValue);
        }
        return headers;
    }

    public revokeToken(): void {
        const token: string = this.oidcSecurityService.getToken();

        if (token !== '') {
            const revocationEndpoint: string = this.authWellKnownEndpoints.revocation_endpoint;

            const headers: HttpHeaders = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

            const params: any = {
                token: token,
                token_type_hint: "access_token"
            };

            const body: string = this.encodeParams(params);

            this.http.post(revocationEndpoint, body, { headers: headers })
                .subscribe();
        }
    }

    private encodeParams(params: any): string {
        let body: string = "";
        for (const key in params) {
            if (body.length) {
                body += "&";
            }
            body += key + "=";
            body += encodeURIComponent(params[key]);
        }
        return body;
    }

}
