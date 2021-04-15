import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import { PanierState } from 'src/shared/states/panier-state';

@Component({
  selector: 'app-detail-produit',
  templateUrl: './detail-produit.component.html',
  styleUrls: ['./detail-produit.component.css']
})
export class DetailProduitComponent implements OnInit {

  public idProduit : any;
  
  constructor(private route : ActivatedRoute) { }

  ngOnInit(): void {
    let id = this.route.snapshot.paramMap.get("id");
    this.idProduit = id;

  }

}
