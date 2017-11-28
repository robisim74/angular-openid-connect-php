import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';

import { OAuthService } from 'angular-oauth2-oidc';

import { User } from '../models/user';

@Injectable() export class AuthService {

    // As in OAuthConfig.
    public storage: Storage = sessionStorage;

    /**
     * Behavior subjects of the user's status & data.
     */
    private signinStatus = new BehaviorSubject<boolean>(false);
    private user = new BehaviorSubject<User>(new User());

    constructor(
        private http: HttpClient,
        private router: Router,
        private oAuthService: OAuthService
    ) { }

    public init(): void {
        // Tells all the subscribers about the new status & data.
        this.signinStatus.next(true);
        this.user.next(this.getUser());
    }

    public signout(): void {
        // Because we are using a Reference token as Access token we can revoke it.
        this.revokeToken();
        this.removeItem('discoveryDocument');
        this.removeItem('redirectUrl');

        // Tells all the subscribers about the new status & data.
        this.signinStatus.next(false);
        this.user.next(new User());

        this.oAuthService.logOut();
    }

    public refreshSession(): void {
        this.revokeToken();
        this.removeItem('discoveryDocument');
        // Stores the attempted URL for redirecting.
        this.setItem('redirectUrl', this.router.url);

        // Tells all the subscribers about the new status & data.
        this.signinStatus.next(false);
        this.user.next(new User());

        this.oAuthService.initImplicitFlow();
    }

    public getItem(key: string): any {
        return JSON.parse(this.storage.getItem(key));
    }

    public setItem(key: string, value: any): void {
        this.storage.setItem(key, JSON.stringify(value));
    }

    public removeItem(key: string): void {
        this.storage.removeItem(key);
    }

    public getAuthorizationHeader(): HttpHeaders {
        // Creates header for the auth requests.
        let headers: HttpHeaders = new HttpHeaders().set('Content-Type', 'application/json');
        headers = headers.append('Accept', 'application/json');

        const token: string = this.oAuthService.getAccessToken();
        if (token !== '') {
            const tokenValue: string = 'Bearer ' + token;
            headers = headers.append('Authorization', tokenValue);
        }
        return headers;
    }

    public isSignedIn(): Observable<boolean> {
        return this.signinStatus.asObservable();
    }

    public userChanged(): Observable<User> {
        return this.user.asObservable();
    }

    public isInGroup(group: string): boolean {
        const user: User = this.getUser();
        const groups: string[] = user && typeof user.groups !== "undefined" ? user.groups : [];
        return groups.indexOf(group) != -1;
    }

    public getUser(): User {
        const user: User = new User();
        if (this.oAuthService.hasValidAccessToken()) {
            const userInfo: any = this.oAuthService.getIdentityClaims();

            user.givenName = userInfo.given_name || "";
            user.familyName = userInfo.family_name || "";
            user.email = userInfo.email;
            user.groups = userInfo.groups;
        }
        return user;
    }

    public revokeToken(): void {
        const token: string = this.oAuthService.getAccessToken();

        if (token !== '') {
            const revocationEndpoint: string = this.getItem('discoveryDocument').revocation_endpoint;

            const headers: HttpHeaders = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

            const params: any = {
                token: token,
                token_type_hint: 'access_token'
            };

            const body: string = this.encodeParams(params);

            this.http.post(revocationEndpoint, body, { headers: headers })
                .subscribe();
        }
    }

    private encodeParams(params: any): string {
        let body = '';
        for (const key of Object.keys(params)) {
            if (body.length) {
                body += '&';
            }
            body += key + '=';
            body += encodeURIComponent(params[key]);
        }
        return body;
    }

}
