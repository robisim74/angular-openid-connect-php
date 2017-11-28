import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { map } from 'rxjs/operators';

import { AuthService } from './auth.service';

/**
 * Decides if a route can be activated.
 */
@Injectable() export class AuthGuard implements CanActivate {

    constructor(
        private router: Router,
        private authService: AuthService) { }

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | boolean {
        return this.authService.isSignedIn().pipe(
            map((signedIn: boolean) => {
                if (signedIn) {
                    return true;
                }

                // Stores the attempted URL for redirecting.
                this.authService.setItem('redirectUrl', state.url);

                // Not signed in so redirects to unauthorized page.
                this.router.navigate(['/unauthorized']);
                return false;
            })
        );
    }

}
