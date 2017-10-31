import { Component, OnInit } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';

import {
    OidcSecurityService,
    OidcSecurityCheckSession,
    OidcSecuritySilentRenew,
    AuthorizationResult
} from 'angular-auth-oidc-client';

import { AuthService } from './services/auth.service';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {

    navItems: any[] = [
        { name: 'Home', route: 'home' },
        { name: 'Resource', route: 'resource' }
    ];

    isAuthorized = false;
    userData: any;

    constructor(
        public title: Title,
        private router: Router,
        private oidcSecurityService: OidcSecurityService,
        private oidcSecurityCheckSession: OidcSecurityCheckSession,
        private oidcSecuritySilentRenew: OidcSecuritySilentRenew,
        private authService: AuthService
    ) {
        // Adds "prompt=none" for silent renew.
        const service: any = (this.oidcSecuritySilentRenew as any);
        const originalStartRenew: any = service.startRenew;
        service.startRenew = (url: string) => {
            originalStartRenew.call(this.oidcSecuritySilentRenew, url += '&prompt=' + 'none');
        };

        if (this.oidcSecurityService.moduleSetup) {
            this.doCallbackLogicIfRequired();
        } else {
            this.oidcSecurityService.onModuleSetup.subscribe(() => {
                this.doCallbackLogicIfRequired();
            });
        }

        // Manages route.
        this.oidcSecurityService.onAuthorizationResult.subscribe(
            (result: AuthorizationResult) => {
                switch (result) {
                    case AuthorizationResult.authorized:
                        // Gets the redirect URL from authentication service.
                        // If no redirect has been set, uses the default.
                        const redirectUrl: string = this.authService.getRedirectUrl()
                            ? this.authService.getRedirectUrl()
                            : '/home';
                        // Redirects the user.
                        this.router.navigate([redirectUrl]);
                        break;
                    case AuthorizationResult.forbidden:
                        this.router.navigate(['/forbidden']);
                        break;
                    case AuthorizationResult.unauthorized:
                        this.router.navigate(['/unauthorized']);
                        break;
                    default:
                        this.router.navigate(['/home']);
                }
            }
        );

        // Session management.
        this.oidcSecurityCheckSession.onCheckSessionChanged.subscribe(
            () => {
                this.refreshSession();
            });
    }

    ngOnInit(): void {
        this.title.setTitle('Angular OIDC PHP');

        this.oidcSecurityService.getIsAuthorized().subscribe(
            (isAuthorized: boolean) => {
                this.isAuthorized = isAuthorized;
            });

        this.oidcSecurityService.getUserData().subscribe(
            (userData: any) => {
                this.userData = userData;
            });
    }

    login(): void {
        this.oidcSecurityService.authorize();
    }

    logout(): void {
        // Because we are using a Reference token as Access token we can revoke it.
        this.authService.revokeToken();
        this.authService.removeRedirectUrl();

        this.oidcSecurityService.logoff();
    }

    refreshSession(): void {
        this.authService.revokeToken();
        // Stores the attempted URL for redirecting.
        this.authService.setRedirectUrl(this.router.url);
        this.oidcSecurityService.authorize();
    }

    private doCallbackLogicIfRequired(): void {
        if (window.location.hash || window.location.search) {
            this.oidcSecurityService.authorizedCallback();
        }
    }

}
