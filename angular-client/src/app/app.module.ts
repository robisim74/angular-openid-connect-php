import { NgModule } from '@angular/core';
import { BrowserModule, Title } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { AuthModule, OidcSecurityService, OpenIDImplicitFlowConfiguration } from 'angular-auth-oidc-client';

import { AppRoutingModule } from './app-routing.module';
import { SharedModule } from './shared/shared.module';

import { AuthGuard } from './services/auth.guard';
import { AuthService } from './services/auth.service';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { UnauthorizedComponent } from './unauthorized/unauthorized.component';
import { ForbiddenComponent } from './forbidden/forbidden.component';

@NgModule({
    declarations: [
        AppComponent,
        HomeComponent,
        UnauthorizedComponent,
        ForbiddenComponent
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        AppRoutingModule,
        SharedModule,
        AuthModule.forRoot()
    ],
    providers: [
        Title,
        AuthGuard,
        AuthService
    ],
    bootstrap: [AppComponent]
})
export class AppModule {

    constructor(public oidcSecurityService: OidcSecurityService) {

        // angular-auth-oidc-client configuration.
        const openIDImplicitFlowConfiguration = new OpenIDImplicitFlowConfiguration();
        openIDImplicitFlowConfiguration.stsServer = 'http://localhost';
        openIDImplicitFlowConfiguration.redirect_url = 'http://localhost:4200';
        openIDImplicitFlowConfiguration.client_id = 'AngularClient';
        openIDImplicitFlowConfiguration.response_type = 'id_token token';
        openIDImplicitFlowConfiguration.scope = 'openid offline_access profile email groups resource';
        openIDImplicitFlowConfiguration.post_logout_redirect_uri = 'http://localhost:4200';
        openIDImplicitFlowConfiguration.trigger_authorization_result_event = true;
        openIDImplicitFlowConfiguration.start_checksession = true;
        openIDImplicitFlowConfiguration.silent_renew = false;
        openIDImplicitFlowConfiguration.silent_renew_offset_in_seconds = 10;
        openIDImplicitFlowConfiguration.post_login_route = '/home';
        openIDImplicitFlowConfiguration.forbidden_route = '/forbidden';
        openIDImplicitFlowConfiguration.unauthorized_route = '/unauthorized';
        openIDImplicitFlowConfiguration.auto_userinfo = true;
        openIDImplicitFlowConfiguration.log_console_warning_active = true;
        openIDImplicitFlowConfiguration.log_console_debug_active = true;
        openIDImplicitFlowConfiguration.max_id_token_iat_offset_allowed_in_seconds = 10;
        openIDImplicitFlowConfiguration.override_well_known_configuration = true
        openIDImplicitFlowConfiguration.override_well_known_configuration_url = 'http://localhost/angular-openid-connect-php/server/.well-known/openid-configuration';

        this.oidcSecurityService.setupModule(openIDImplicitFlowConfiguration);
    }
}
