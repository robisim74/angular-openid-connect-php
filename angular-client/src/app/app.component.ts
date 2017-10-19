import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';

import { OidcSecurityService } from 'angular-auth-oidc-client';

import { AuthService } from './services/auth.service';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy {

    isAuthorizedSubscription: Subscription;
    isAuthorized: boolean;

    constructor(
        private router: Router,
        private oidcSecurityService: OidcSecurityService,
        private auth: AuthService
    ) {
        if (this.oidcSecurityService.moduleSetup) {
            this.doCallbackLogicIfRequired();
        } else {
            this.oidcSecurityService.onModuleSetup.subscribe(() => {
                this.doCallbackLogicIfRequired();
            });
        }

        // Manages route on authorized = 1, forbidden = 2, unauthorized = 3.
        this.oidcSecurityService.onAuthorizationResult.subscribe(
            (result: any) => {
                if (result == 1) {
                    this.router.navigate(['/resource']);
                }
            }
        );
    }

    ngOnInit() {
        this.isAuthorizedSubscription = this.oidcSecurityService.getIsAuthorized().subscribe(
            (isAuthorized: boolean) => {
                this.isAuthorized = isAuthorized;
            });
    }

    ngOnDestroy(): void {
        this.isAuthorizedSubscription.unsubscribe();
        this.oidcSecurityService.onModuleSetup.unsubscribe();
    }

    login() {
        console.log('start login');
        this.oidcSecurityService.authorize();
    }

    refreshSession() {
        console.log('start refreshSession');
        this.oidcSecurityService.authorize();
    }

    logout() {
        console.log('start logoff');

        this.auth.revokeToken();

        this.oidcSecurityService.logoff();
    }

    private doCallbackLogicIfRequired() {
        if (window.location.hash) {
            this.oidcSecurityService.authorizedCallback();
        }
    }

}
