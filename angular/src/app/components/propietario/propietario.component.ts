import { Component, OnInit } from '@angular/core';
import {GaleriaService} from '../../services/galeria.service';
import { Propietario } from '../../models/propietario';

@Component({
  selector: 'app-propietario',
  templateUrl: './propietario.component.html',
  styleUrls: ['./propietario.component.css']
})
export class PropietarioComponent implements OnInit {
  submitted = false;
  btnactualizar = false;
  array: Array<Propietario> = [];
  propietario: Propietario = new Propietario();

  constructor(private servicio: GaleriaService ) {
    this.servicio.route = 'propietario';
  }

  onSubmit() {
    this.submitted = true;
  }

  ngOnInit() {
    this.refreshList();
  }

public refreshList() {
    this.servicio.getAll().subscribe(
      result => {
        this.array = JSON.parse(result.propietarios);
      },
      error => {
        console.log(error);
      }
    );
  }

  public update() {
    this.servicio.update(this.propietario).subscribe(
      result => {
        console.log('update correcto');
        this.propietario = new Propietario();
        this.btnactualizar = false;
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  public save() {
    this.servicio.save(this.propietario).subscribe(
      data => {
        console.log('envio ok');
        console.log('agregado correctamente.');
        this.propietario = new Propietario();
        this.refreshList();
        this.btnactualizar = false;
        return true;
      },
      error => {
        console.error('Error saving!');
        console.log(error);
        return false;
      }
    );
  }

  eliminar(objeto: any) {
    this.servicio.delete(objeto).subscribe(
      result => {
        console.log('envio delete');
        this.refreshList();
      },
      error => console.log('error: ' + error)
    );
  }

  elegir(objeto: any) {
    this.propietario = this.array.filter(x => x === objeto).pop();
    this.btnactualizar = true;
  }
}
