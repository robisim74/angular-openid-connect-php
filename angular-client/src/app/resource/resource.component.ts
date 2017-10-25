import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Router } from '@angular/router';

import { AuthConfiguration } from 'angular-auth-oidc-client';
import { Chart } from 'chart.js';

import { AuthService } from '../services/auth.service';

@Component({
    selector: 'app-resource',
    templateUrl: './resource.component.html',
    styleUrls: ['./resource.component.scss']
})
export class ResourceComponent implements OnInit {

    results: any;

    constructor(
        private router: Router,
        private http: HttpClient,
        private authConfiguration: AuthConfiguration,
        private auth: AuthService) { }

    ngOnInit() {
        // Sends an authenticated request.
        this.http
            .get(this.authConfiguration.stsServer + "/api/resource", {
                headers: this.auth.getAuthorizationHeader()
            })
            .subscribe(
            (data: any) => {
                this.results = data;
            },
            (error: HttpErrorResponse) => {
                if (error.error instanceof Error) {
                    console.log('An error occurred:', error.error.message);
                } else {
                    console.log(`Backend returned code ${error.status}, body was: ${error.error}`);
                }
                this.router.navigate(['/unauthorized']);
            });
    }
}
