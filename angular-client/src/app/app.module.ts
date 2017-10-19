import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';

import { AuthModule, OidcSecurityService, OpenIDImplicitFlowConfiguration } from 'angular-auth-oidc-client';

import { AppRoutingModule } from './app-routing.module';

import { AuthService } from './services/auth.service';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { UnauthorizedComponent } from './unauthorized/unauthorized.component';

@NgModule({
    declarations: [
        AppComponent,
        HomeComponent,
        UnauthorizedComponent
    ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        HttpClientModule,
        HttpModule,
        AuthModule.forRoot()
    ],
    providers: [
        AuthService
    ],
    bootstrap: [AppComponent]
})
export class AppModule {

    constructor(public oidcSecurityService: OidcSecurityService) {
        const openIDImplicitFlowConfiguration = new OpenIDImplicitFlowConfiguration();
        openIDImplicitFlowConfiguration.stsServer = 'http://localhost/angular-openid-connect-php/server/index.php';
        openIDImplicitFlowConfiguration.redirect_url = 'http://localhost:4200';
        openIDImplicitFlowConfiguration.client_id = 'angularclient';
        openIDImplicitFlowConfiguration.response_type = 'id_token token';
        openIDImplicitFlowConfiguration.scope = 'openid offline_access profile email groups resource';
        openIDImplicitFlowConfiguration.post_logout_redirect_uri = 'http://localhost:4200';
        openIDImplicitFlowConfiguration.trigger_authorization_result_event = true,
        openIDImplicitFlowConfiguration.start_checksession = false;
        openIDImplicitFlowConfiguration.silent_renew = false;
        openIDImplicitFlowConfiguration.silent_renew_offset_in_seconds = 0;
        openIDImplicitFlowConfiguration.startup_route = '/home';
        openIDImplicitFlowConfiguration.forbidden_route = '/forbidden';
        openIDImplicitFlowConfiguration.unauthorized_route = '/unauthorized';
        openIDImplicitFlowConfiguration.auto_userinfo = true;
        openIDImplicitFlowConfiguration.log_console_warning_active = true;
        openIDImplicitFlowConfiguration.log_console_debug_active = true;
        openIDImplicitFlowConfiguration.max_id_token_iat_offset_allowed_in_seconds = 10;
        openIDImplicitFlowConfiguration.override_well_known_configuration = false;

        this.oidcSecurityService.setupModule(openIDImplicitFlowConfiguration);
    }
}

