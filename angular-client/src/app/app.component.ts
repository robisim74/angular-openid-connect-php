import { Component, OnInit } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';

import { OAuthService, JwksValidationHandler } from 'angular-oauth2-oidc';

import { AuthService } from './services/auth.service';
import { User } from './models/user';
import { oAuthDevelopmentConfig, oAuthProductionConfig } from './oauth.config';
import { environment } from '../environments/environment';

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

    signedIn: Observable<boolean>;
    email: string;

    constructor(
        public title: Title,
        private router: Router,
        private oAuthService: OAuthService,
        private authService: AuthService
    ) {
        let url: string

        if (environment.production) {
            // Production environment.
            this.oAuthService.configure(oAuthProductionConfig);
            url = 'http://angular-oidc-php.infinityfreeapp.com/server/.well-known/openid-configuration';
        } else {
            // Development environment.
            this.oAuthService.configure(oAuthDevelopmentConfig);
            url = 'http://localhost/angular-openid-connect-php/server/.well-known/openid-configuration';
        }

        // Defines the storage.
        this.oAuthService.setStorage(sessionStorage);

        this.oAuthService.tokenValidationHandler = new JwksValidationHandler();

        // Loads discovery document & tries login.
        this.oAuthService.loadDiscoveryDocument(url).then((doc: any) => {
            // Stores discovery document.
            this.authService.setItem('discoveryDocument', doc.info.discoveryDocument);
            // Tries login.
            this.oAuthService.tryLogin({
                onTokenReceived: context => {
                    // Loads user profile.
                    this.oAuthService.loadUserProfile().then(() => {
                        this.authService.init();

                        // Gets the redirect URL.
                        // If no redirect has been set, uses the default.
                        const redirect: string = this.authService.getItem('redirectUrl')
                            ? this.authService.getItem('redirectUrl')
                            : '/home';
                        // Redirects the user.
                        this.router.navigate([redirect]);
                    });
                }
            }).then(() => {
                // Manages consent error.
                if (window.location.search && window.location.search.match(/\^?error=consent_required/) != null) {
                    this.router.navigate(['/forbidden']);
                }
            });
        });

        // Setups silent refresh.
        this.oAuthService.setupAutomaticSilentRefresh();

        // Events.
        // On silently refreshed.
        this.oAuthService.events.filter(e => e.type === 'silently_refreshed').subscribe(e => {
            this.oAuthService.loadUserProfile();
        });

        // On session terminated.
        this.oAuthService.events.filter(e => e.type === 'session_terminated').subscribe(e => {
            this.authService.refreshSession();
        });

        // Already authorized.
        if (this.oAuthService.hasValidAccessToken()) {
            this.authService.init();
        }
    }

    ngOnInit(): void {
        this.title.setTitle('Angular OIDC PHP');

        this.signedIn = this.authService.isSignedIn();

        this.authService.userChanged().subscribe(
            (user: User) => {
                this.email = user.email;
            });
    }

    login(): void {
        this.oAuthService.initImplicitFlow();
    }

    logout(): void {
        this.authService.signout();
    }

}
