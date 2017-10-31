import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';

import { OidcSecurityService } from 'angular-auth-oidc-client';

import { AuthService } from './auth.service';

/**
 * Decides if a route can be activated.
 */
@Injectable() export class AuthGuard implements CanActivate {

    constructor(
        private router: Router,
        private oidcSecurityService: OidcSecurityService,
        private authService: AuthService) { }

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | boolean {
        return this.oidcSecurityService.getIsAuthorized()
            .map((isAuthorized: boolean) => {
                if (isAuthorized) {
                    return true;
                }

                // Stores the attempted URL for redirecting.
                this.authService.setRedirectUrl(state.url);

                // Not signed in so redirects to signin page.
                this.oidcSecurityService.authorize();
                return false;
            });
    }

}
