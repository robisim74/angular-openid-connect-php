import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

import { AuthService } from '../services/auth.service';

@Component({
    selector: 'app-resource',
    templateUrl: './resource.component.html',
    styleUrls: ['./resource.component.scss']
})
export class ResourceComponent implements OnInit {

    results: any;

    constructor(private http: HttpClient, private auth: AuthService) { }

    ngOnInit() {
        // Sends an authenticated request.
        this.http
            .get("http://localhost/angular-openid-connect-php/server/index.php/resource", {
                headers: this.auth.getAuthorizationHeader()
            })
            .subscribe(
            (data: any) => {
                this.results = data;
            },
            (error: HttpErrorResponse) => {
                if (error.error instanceof Error) {
                    // A client-side or network error occurred. Handle it accordingly.
                    console.log('An error occurred:', error.error.message);
                } else {
                    // The backend returned an unsuccessful response code.
                    // The response body may contain clues as to what went wrong,
                    console.log(`Backend returned code ${error.status}, body was: ${error.error}`);
                }
            });
    }
}
