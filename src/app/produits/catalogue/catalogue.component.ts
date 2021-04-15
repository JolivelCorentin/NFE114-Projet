import { Component, OnInit } from '@angular/core';

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { from, Observable } from "rxjs";
import { environment } from '../../../environments/environment';
import { Store } from '@ngxs/store';
import {AddReference} from '../../../shared/actions/panier.action';
import {Router} from '@angular/router';


@Component({
  selector: 'app-catalogue',
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css']
})
export class CatalogueComponent implements OnInit {

  produits$ : any = this.getProduits();


  ngOnInit(): void {


  }

  data : string [];

  constructor(private httpClient : HttpClient, private store : Store, private router : Router) { 
    this.data = new Array<string> ();  
  }
  public getProduits () : Observable<any> {
    return this.httpClient.get<any> (environment.baseUrl);
  }


  addPanier (ref : string) {
    console.log (ref);
    this.store.dispatch (new AddReference ({"reference":ref}));
  }

  voirDetails(tel: string){
    this.router.navigate(["/produits/detail-produit", tel]);
    
  }



}
