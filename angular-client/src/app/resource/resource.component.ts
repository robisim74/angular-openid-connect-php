import { Component, OnInit, ElementRef } from '@angular/core';
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

    resourceChart: any;

    options: any = {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Dev Productivity'
        },
        responsive: true
    };

    months: string[] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    constructor(
        private router: Router,
        private elementRef: ElementRef,
        private http: HttpClient,
        private authConfiguration: AuthConfiguration,
        private auth: AuthService) { }

    ngOnInit() {
        const ctx: HTMLElement = this.elementRef.nativeElement.querySelector('#resourceChart');
        this.createChart(ctx);

        // Sends an authenticated request.
        this.http
            .get(this.authConfiguration.stsServer + '/api/resource', {
                headers: this.auth.getAuthorizationHeader()
            })
            .subscribe(
            (data: any) => {
                console.log(data);
                this.populateChart(data, this.months);
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

    createChart(ctx: HTMLElement): void {
        this.resourceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Productivity',
                        data: [],
                        backgroundColor: '#767bb3',
                        fill: false
                    }
                ]
            },
            options: this.options
        });
    }

    populateChart(data: number[], labels: string[]): void {
        this.resourceChart.data.labels = labels;
        this.resourceChart.data.datasets[0].data = data;
        this.resourceChart.update();
    }

}
