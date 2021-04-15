import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import {CatalogueComponent}  from './catalogue/catalogue.component';
import { DetailProduitComponent } from './detail-produit/detail-produit.component';
import { RouterModule, Routes } from '@angular/router';
import { PanierComponent } from './panier/panier.component';

const appRoutes : Routes = [
  {path:'catalogue', component:CatalogueComponent},
  {path:'detail-produit/:id', component: DetailProduitComponent },
  {path:'panier', component: PanierComponent }
]

@NgModule({
  declarations: [CatalogueComponent, DetailProduitComponent, PanierComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(appRoutes)
  ]
})
export class ProduitsModule { }
