import { AuthConfig } from 'angular-oauth2-oidc';

export const oAuthDevelopmentConfig: AuthConfig = {

    clientId: "AngularClient",
    redirectUri: "http://localhost:4200",
    postLogoutRedirectUri: "http://localhost:4200",
    scope: "openid offline_access profile email groups resource",
    oidc: true,
    issuer: "http://localhost",
    requireHttps: false,
    responseType: "id_token token",
    showDebugInformation: true,
    timeoutFactor: 0.90,
    sessionChecksEnabled: true,
    sessionCheckIntervall: 5 * 1000,
    silentRefreshRedirectUri: "http://localhost:4200/silent-refresh.html",
    silentRefreshTimeout: 5 * 1000

}

export const oAuthProductionConfig: AuthConfig = {

    clientId: "AngularClient",
    redirectUri: "http://angular-oidc-php.infinityfreeapp.com",
    postLogoutRedirectUri: "http://angular-oidc-php.infinityfreeapp.com",
    scope: "openid offline_access profile email groups resource",
    oidc: true,
    issuer: "http://angular-oidc-php.infinityfreeapp.com",
    requireHttps: false,
    responseType: "id_token token",
    timeoutFactor: 0.90,
    sessionChecksEnabled: true,
    sessionCheckIntervall: 5 * 1000,
    silentRefreshRedirectUri: "http://angular-oidc-php.infinityfreeapp.com/silent-refresh.html",
    silentRefreshTimeout: 5 * 1000

}
