import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { GaleriaService } from '../../services/galeria.service';
import { Local } from '../../models/local';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  
  array: Array<Local> = [];
  local: Local = new Local();


  constructor(private servicio: GaleriaService ) {
    this.servicio.route = 'local';
   }
  
  ngOnInit() {
    this.refreshList();
  }

public refreshList() {
    this.servicio.getAll().subscribe(
      result => {
        this.array = JSON.parse(result.locales);
      },
      error => {
        console.log(error);
      }
    );
  }

  
  
  elegir(objeto: any) {
    this.local = this.array.filter(x => x === objeto).pop();
  
  }
}
  

